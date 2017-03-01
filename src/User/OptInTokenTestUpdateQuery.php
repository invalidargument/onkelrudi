<?php

namespace RudiBieller\OnkelRudi\User;

class OptInTokenTestUpdateQuery extends OptInTokenUpdateQuery
{
    private $_identifier;

    /**
     * @param String $identifier User ID (e-mail address)
     * @return OptInTokenTestUpdateQuery
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    protected function runQuery()
    {
        $optInInformation = $this->getOptInInformation();

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

    protected function getOptInInformation()
    {
        return array('email' => $this->_identifier);
    }
}
