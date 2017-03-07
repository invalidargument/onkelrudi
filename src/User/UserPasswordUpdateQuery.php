<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class UserPasswordUpdateQuery extends AbstractInsertQuery
{
    private $_identifier;
    private $_password;

    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    protected function runQuery()
    {
        $updateStatement = $this->pdo
            ->update(array('password' => $this->_password))
            ->table('fleamarkets_users')
            ->where('email', '=', $this->_identifier);

        return $updateStatement->execute();
    }
}
