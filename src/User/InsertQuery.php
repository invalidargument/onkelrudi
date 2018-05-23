<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class InsertQuery extends AbstractInsertQuery
{
    private $_identifier;
    private $_password;
    private $_type;

    /**
     * @param string $identifier
     * @return InsertQuery
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    /**
     * @param string $password
     * @return InsertQuery
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * @param string $type
     * @return InsertQuery
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    protected function runQuery()
    {
        //$date = date('Y-m-d H:i:s');
        $date = new \DateTime(date('Y-m-d H:i:s'));

        $insertStatement = $this->pdo
            ->insert(
                array('email', 'password', 'type', 'opt_in_dsgvo', 'opt_in_dsgvo_ts')
            )
            ->into('fleamarkets_users')
            ->values(
                array($this->_identifier, $this->_password, $this->_getType(), true, $date->format('Y-m-d H:i:s'))
            );

        return $insertStatement->execute();
    }

    private function _getType()
    {
        $valid = array(UserInterface::TYPE_ADMIN, UserInterface::TYPE_ORGANIZER, UserInterface::TYPE_USER);

        return in_array($this->_type, $valid) ? $this->_type : UserInterface::TYPE_USER;
    }
}
