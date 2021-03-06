<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\FleaMarket\Organizer as FleamarketOrganizer;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface;
use Slim\Container;

class UserService implements UserServiceInterface
{
    /**
     * @var \RudiBieller\OnkelRudi\User\QueryFactory
     */
    private $_factory;
    private static $_authenticationService;

    /**
     * @var \RudiBieller\OnkelRudi\User\AuthenticationFactory
     */
    private $_authFactory;

    /**
     * @var OrganizerServiceInterface
     */
    private $_organizerService;

    private $_diContainer;

    public function setDiContainer(Container $diContainer)
    {
        $this->_diContainer = $diContainer;
    }

    public function setQueryFactory(QueryFactory $factory)
    {
        $this->_factory = $factory;
    }

    public function setAuthenticationFactory(AuthenticationFactory $factory)
    {
        $this->_authFactory = $factory;
    }

    public function setOrganizerService(OrganizerServiceInterface $organizerService)
    {
        $this->_organizerService = $organizerService;
    }
    
    public function createUser($identifier, $password)
    {
        $userQuery = $this->_factory->createUserInsertQuery();
        $userQuery->setIdentifier($identifier)->setPassword($password)->setType(UserInterface::TYPE_USER);
        return $userQuery->run();
    }

    public function createOrganizerUser($identifier, $password)
    {
        // should rather be a composite query...
        $this->_diContainer->get('db')->beginTransaction();

        $userQuery = $this->_factory->createUserInsertQuery();
        $userQuery->setIdentifier($identifier)->setPassword($password)->setType(UserInterface::TYPE_ORGANIZER);
        $userQuery->run();

        $organizer = new FleamarketOrganizer();
        $organizer->setName($identifier);
        $organizerId = $this->_organizerService->createOrganizer($organizer);

        $userToOrganizerQuery = $this->_factory->createUserToOrganizerInsertQuery();
        $result = $userToOrganizerQuery->setUserId($identifier)->setOrganizerId($organizerId)->run();

        if ($result == 0) {
            $this->_diContainer->get('db')->commit();
            return $identifier;
        }

        $this->_diContainer->get('db')->rollback();
        return -1;
    }

    public function createAdminUser($identifier, $password)
    {
        $userQuery = $this->_factory->createUserInsertQuery();
        $userQuery->setIdentifier($identifier)->setPassword($password)->setType(UserInterface::TYPE_ADMIN);
        return $userQuery->run();
    }

    public function createOptInToken($identifier)
    {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $optInQuery = $this->_factory->createOptInTokenInsertQuery();
        $optInQuery->setIdentifier($identifier)->setToken($token);
        $optInQuery->run();

        return $token;
    }

    public function createTestOptInToken($identifier, $token)
    {
        $optInQuery = $this->_factory->createOptInTokenInsertQuery();
        $optInQuery->setIdentifier($identifier)->setToken($token);
        $optInQuery->run();

        return $token;
    }

    public function login(UserInterface $user)
    {
        $dbAdapter = $this->_authFactory->createAuthAdapter($user);
        $sessionStorage = $this->_authFactory->createSessionStorage();
        $authService = $this->_authFactory->createAuthService($dbAdapter, $sessionStorage);

        /**
         * @var \Zend\Authentication\Result
         */
        return $authService->authenticate();
    }

    public function isLoggedIn()
    {
        $user = $this->getAuthenticationService()->getStorage()->read();

        return !is_null($user);
    }

    public function getAuthenticationService(UserInterface $user = null)
    {
        if (is_null(self::$_authenticationService)) {
            $dbAdapter = $this->_authFactory->createAuthAdapter();
            if (!is_null($user)) {
                $dbAdapter->setIdentifier($user->getIdentifier())
                    ->setPassword($user->getPassword());
            }
            $sessionStorage = $this->_authFactory->createSessionStorage();
            self::$_authenticationService = $this->_authFactory->createAuthService($dbAdapter, $sessionStorage);
        }

        return self::$_authenticationService;
    }

    public function optIn($token)
    {
        $optInQuery = $this->_factory->createOptInTokenUpdateQuery();

        $optInQuery->setToken($token);

        return $optInQuery->run();
    }

    /**
     * @inheritdoc
     */
    public function optInTestUser($identifier)
    {
        $optInQuery = $this->_factory->createOptInTokenTestUpdateQuery();

        $optInQuery->setIdentifier($identifier);

        return $optInQuery->run();
    }

    public function getUser($identifier)
    {
        $query = $this->_factory->createUserReadQuery();

        $query->setIdentifier($identifier);

        return $query->run();
    }

    public function changePassword(UserInterface $user, $newPassword)
    {
        $query = $this->_factory->createUserPasswordUpdateQuery();

        $query
            ->setIdentifier($user->getIdentifier())
            ->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));

        return $query->run();
    }

    public function getOrganizerIdByUserId($userId)
    {
        $query = $this->_factory->createUserToOrganizerReadQuery();

        $query->setIdentifier($userId);

        return $query->run();
    }
}
