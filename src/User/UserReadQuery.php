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
        $userBuilder = $this->diContainer->get('UserBuilder');
        $userBuilder->reset();

        return $userBuilder
            ->setIdentifier($this->_identifier)
            ->setType($result['type'])
            ->setOptIn($result['opt_in'])
            ->build();
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
