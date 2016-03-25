<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractQuery;

class LoginQuery extends AbstractQuery
{
    private $_identifier;
    
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    protected function mapResult($result)
    {
        return $result;
    }

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_users')
            ->where('email', '=', $this->_identifier);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetch(\PDO::FETCH_COLUMN);
    }
}
