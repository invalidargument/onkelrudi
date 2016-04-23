<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class OptInTokenInsertQuery extends AbstractInsertQuery
{
    private $_identifier;
    private $_token;

    /**
     * @param string $identifier
     * @return OptInTokenInsertQuery
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    /**
     * @param string $token
     * @return OptInTokenInsertQuery
     */
    public function setToken($token)
    {
        $this->_token = $token;
        return $this;
    }

    protected function runQuery()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('email', 'token')
            )
            ->into('fleamarkets_optins')
            ->values(
                array($this->_identifier, $this->_token)
            );

        return $insertStatement->execute();
    }
}
