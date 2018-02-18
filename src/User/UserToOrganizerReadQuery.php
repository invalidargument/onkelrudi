<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractQuery;

class UserToOrganizerReadQuery extends AbstractQuery
{
    private $_identifier;

    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    protected function mapResult($result)
    {
        if ($result === false) {
            return null;
        }

        return $result['organizer_id'];
    }

    protected function runQuery()
    {
        $selectStatement = $this->getPdo()
            ->select(['organizer_id'])
            ->from('fleamarkets_user_to_organizer')
            ->where('user_id', '=', $this->_identifier);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
