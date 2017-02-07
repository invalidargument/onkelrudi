<?php

namespace RudiBieller\OnkelRudi\Query;

use RudiBieller\OnkelRudi\CacheableInterface;
use Slim\Container;
use \Slim\PDO\Database;

abstract class AbstractQuery implements QueryInterface
{
    const TTL = 3600;

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

        if ($this instanceof CacheableInterface) {
            $result = $this->diContainer->get('CacheManager')->get($this->getCacheKey());

            if (is_null($result)) {
                $result = $this->runQuery();
                $this->diContainer->get('CacheManager')->set($this->getCacheKey(), $result, $this->getTtl());
            }
        } else {
            $result = $this->runQuery();
        }

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

    protected function getCacheKey()
    {
        return self::class;
    }

    private function _createPdoInstance()
    {
        return $this->diContainer->db;
    }

    protected function getTtl()
    {
        return self::TTL;
    }
}
