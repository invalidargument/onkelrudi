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
    
    public function createUser($identifier, $password)
    {
        $userQuery = $this->_factory->createUserInsertQuery();
        $userQuery->setIdentifier($identifier)->setPassword($password);
        $result = $userQuery->run();

        if (!$result) {
            return $result;
        }

        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $optInQuery = $this->_factory->createOptInTokenInsertQuery();
        $optInQuery->setIdentifier($identifier)->setToken($token);
        $optInQuery->run();

        return $result;
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
}
