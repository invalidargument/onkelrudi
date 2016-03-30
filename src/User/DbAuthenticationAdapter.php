<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Query\AbstractQuery;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class DbAuthenticationAdapter extends AbstractQuery implements AdapterInterface
{
    private $_identifier;
    private $_password;

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    public function authenticate()
    {
        $hash = $this->runQuery();

        return $this->mapResult($hash);
    }

    protected function mapResult($hash)
    {
        if (!$hash) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->_identifier);
        }

        if (password_verify($this->_password, $hash)) {
            return new Result(Result::SUCCESS, $this->_identifier);
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->_identifier);
    }

    protected function runQuery()
    {
        $selectStatement = $this->getPdo()
            ->select(['password'])
            ->from('fleamarkets_users')
            ->where('email', '=', $this->_identifier)
            ->where('opt_in', '=', '1');

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetch(\PDO::FETCH_COLUMN);
    }
}
