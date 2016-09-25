<?php

namespace RudiBieller\OnkelRudi\User;

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

    public function setQueryFactory(QueryFactory $factory)
    {
        $this->_factory = $factory;
    }

    public function setAuthenticationFactory(AuthenticationFactory $factory)
    {
        $this->_authFactory = $factory;
    }
    
    public function createUser($identifier, $password, $type = null)
    {
        $userQuery = $this->_factory->createUserInsertQuery();
        $userQuery->setIdentifier($identifier)->setPassword($password)->setType($type);
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

    public function isLoggedIn()
    {
        $user = $this->getAuthenticationService()->getStorage()->read();

        return !is_null($user);
    }

    public function getUser($id)
    {
        $query = $this->_factory->createUserReadQuery();

        $query->setIdentifier($id);

        return $query->run();
    }
}
