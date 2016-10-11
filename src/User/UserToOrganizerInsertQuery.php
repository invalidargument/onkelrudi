<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class UserToOrganizerInsertQuery extends AbstractInsertQuery
{
    private $_userId;
    private $_organizerId;

    public function setUserId($userId)
    {
        $this->_userId = $userId;
        return $this;
    }

    public function setOrganizerId($organizerId)
    {
        $this->_organizerId = $organizerId;
        return $this;
    }

    protected function runQuery()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('user_id', 'organizer_id')
            )
            ->into('fleamarkets_user_to_organizer')
            ->values(
                array($this->_userId, $this->_organizerId)
            );

        return $insertStatement->execute();
    }
}
