<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractQuery;

class UserReadQuery extends AbstractQuery
{
    private $_identifier;

    public function setIdentifier($id)
    {
        $this->_identifier = $id;
        return $this;
    }

    protected function mapResult($result)
    {
        return new User($this->_identifier, null, $result['type'], $result['opt_in']);
    }

    protected function runQuery()
    {
        $selectStatement = $this->getPdo()
            ->select(['type', 'opt_in'])
            ->from('fleamarkets_users')
            ->where('email', '=', $this->_identifier);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
