<?php

namespace RudiBieller\OnkelRudi\User;

use Carbon\Carbon;
use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class OptInTokenUpdateQuery extends AbstractInsertQuery
{
    private $_token;

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
        $dateTime = new Carbon();

        // read email from fleamarkets_optins
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_optins')
            ->where('token', '=', $this->_token)
            ->where('created', '>', $dateTime->subDay()->format('Y-m-d H:i:s'));

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        $optInInformation = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$optInInformation) {
            return false;
        }

        // set fleamarkets_users.opt_in to 1 where email == email
        $updateStatement = $this->pdo
            ->update(array('opt_in' => 1))
            ->table('fleamarkets_users')
            ->where('email', '=', $optInInformation['email']);

        return $updateStatement->execute();
    }
}
