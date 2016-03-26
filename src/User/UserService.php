<?php

namespace RudiBieller\OnkelRudi\User;

class UserService implements UserServiceInterface
{
    /**
     * @var \RudiBieller\OnkelRudi\User\QueryFactory
     */
    private $_factory;

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
        $query = $this->_factory->createUserInsertQuery();

        $query->setIdentifier($identifier)->setPassword($password);

        return $query->run();
    }

    public function login($identifier, $password)
    {
        $dbAdapter = $this->_authFactory->createAuthAdapter($identifier, $password);
        $sessionStorage = $this->_authFactory->createSessionStorage();
        $authService = $this->_authFactory->createAuthService($dbAdapter, $sessionStorage);

        /**
         * @var \Zend\Authentication\Result
         */
        return $authService->authenticate();
    }
}
