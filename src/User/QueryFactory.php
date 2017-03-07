<?php

namespace RudiBieller\OnkelRudi\User;

use Slim\Container;

class QueryFactory
{
    private $_insertQuery;
    private $_optInTokenInsertQuery;
    private $_optInTokenUpdateQuery;
    private $_optInTokenTestUpdateQuery;
    private $_userReadQuery;
    private $_userToOrganizerInsertQuery;
    private $_userPasswordChangeQuery;

    private $_diContainer;

    public function setDiContainer(Container $diContainer)
    {
        $this->_diContainer = $diContainer;
    }

    public function createUserInsertQuery()
    {
        if (is_null($this->_insertQuery)) {
            $this->_insertQuery = new InsertQuery();
            $this->_insertQuery->setDiContainer($this->_diContainer);
        }

        return $this->_insertQuery;
    }

    public function createOptInTokenInsertQuery()
    {
        if (is_null($this->_optInTokenInsertQuery)) {
            $this->_optInTokenInsertQuery = new OptInTokenInsertQuery();
            $this->_optInTokenInsertQuery->setDiContainer($this->_diContainer);
        }

        return $this->_optInTokenInsertQuery;
    }

    public function createOptInTokenUpdateQuery()
    {
        if (is_null($this->_optInTokenUpdateQuery)) {
            $this->_optInTokenUpdateQuery = new OptInTokenUpdateQuery();
            $this->_optInTokenUpdateQuery->setDiContainer($this->_diContainer);
        }

        return $this->_optInTokenUpdateQuery;
    }

    public function createOptInTokenTestUpdateQuery()
    {
        if (is_null($this->_optInTokenTestUpdateQuery)) {
            $this->_optInTokenTestUpdateQuery = new OptInTokenTestUpdateQuery();
            $this->_optInTokenTestUpdateQuery->setDiContainer($this->_diContainer);
        }

        return $this->_optInTokenTestUpdateQuery;
    }

    public function createUserReadQuery()
    {
        if (is_null($this->_userReadQuery)) {
            $this->_userReadQuery = new UserReadQuery();
            $this->_userReadQuery->setDiContainer($this->_diContainer);
        }

        return $this->_userReadQuery;
    }

    public function createUserToOrganizerInsertQuery()
    {
        if (is_null($this->_userToOrganizerInsertQuery)) {
            $this->_userToOrganizerInsertQuery = new UserToOrganizerInsertQuery();
            $this->_userToOrganizerInsertQuery->setDiContainer($this->_diContainer);
        }

        return $this->_userToOrganizerInsertQuery;
    }

    public function createUserPasswordUpdateQuery()
    {
        if (is_null($this->_userPasswordChangeQuery)) {
            $this->_userPasswordChangeQuery = new UserPasswordUpdateQuery();
            $this->_userPasswordChangeQuery->setDiContainer($this->_diContainer);
        }

        return $this->_userPasswordChangeQuery;
    }
}
