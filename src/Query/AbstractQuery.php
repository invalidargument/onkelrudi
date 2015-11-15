<?php
namespace RudiBieller\OnkelRudi\Query;

use \Slim\PDO\Database;
use RudiBieller\OnkelRudi\Config\Config;

abstract class AbstractQuery
{
    protected $pdo;

    abstract protected function mapResult();

    public function run()
    {
        $this->mapResult();
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
        $this->pdo = new Database(Config::$dsn, Config::$user, Config::$password);
    }
}