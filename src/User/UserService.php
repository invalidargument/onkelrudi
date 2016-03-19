<?php

namespace RudiBieller\OnkelRudi\User;

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
}
