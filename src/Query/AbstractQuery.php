<?php
namespace RudiBieller\OnkelRudi\Query;

use \Slim\PDO\Database;
use RudiBieller\OnkelRudi\Config\Config;

abstract class AbstractQuery implements QueryInterface
{
    protected $pdo;

    abstract protected function mapResult($result);
    abstract protected function runQuery();

    public function run()
    {
        $this->getPdo();
        $result = $this->runQuery();
        return $this->mapResult($result);
    }

    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }

    protected function getPdo()
    {
        if (is_null($this->pdo)) {
            $this->pdo = $this->_createPdoInstance();
        }

        return $this->pdo;
    }

    private function _createPdoInstance()
    {
        $dbSettings = Config::$database;

        return new Database(
            $dbSettings['dsn'],
            $dbSettings['user'],
            $dbSettings['password']
        );
    }
}
