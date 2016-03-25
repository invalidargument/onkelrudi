<?php

namespace RudiBieller\OnkelRudi\User;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;

class UserService implements UserServiceInterface
{
    /**
     * @var \RudiBieller\OnkelRudi\User\QueryFactory
     */
    private $_factory;

    public function setQueryFactory(QueryFactory $factory)
    {
        $this->_factory = $factory;
    }
    
    public function createUser($identifier, $password)
    {
        $query = $this->_factory->createUserInsertQuery();

        $query->setIdentifier($identifier)->setPassword($password);

        return $query->run();
    }

    public function login($identifier, $password)
    {
        $sessionStorage = null;

        $authAdapter = new DbAuthenticationAdapter();
        $authAdapter->setIdentifier($identifier)->setPassword($password);

        $authService = new AuthenticationService();
        $authService->setAdapter($authAdapter);

        /**
         * @var \Zend\Authentication\Result
         */
        $result = $authService->authenticate();

        return $result;
        // TODO: here, we need to continue with creating a session
    }
}
