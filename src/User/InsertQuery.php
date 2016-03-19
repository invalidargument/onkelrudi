<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class InsertQuery extends AbstractInsertQuery
{
    private $_identifier;
    private $_password;

    /**
     * @param string $identifier
     * @return UserInsertQuery
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    /**
     * @param string $password
     * @return UserInsertQuery
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    protected function runQuery()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('email', 'password')
            )
            ->into('fleamarkets_users')
            ->values(
                array($this->_identifier, $this->_password)
            );

        return $insertStatement->execute();
    }
}