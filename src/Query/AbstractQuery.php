<?php

namespace RudiBieller\OnkelRudi\Query;

use Slim\Container;
use \Slim\PDO\Database;

abstract class AbstractQuery implements QueryInterface
{
    /**
     * @var Database
     */
    protected $pdo;

    /**
     * @var \Slim\Container
     */
    protected $diContainer;

    abstract protected function mapResult($result);
    abstract protected function runQuery();

    public function run()
    {
        $this->getPdo();
        $result = $this->runQuery();
        return $this->mapResult($result);
    }

    public function setDiContainer(Container $diContainer)
    {
        $this->diContainer = $diContainer;
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
        return $this->diContainer->db;
    }
}
