<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class FleaMarketReadListQuery extends AbstractQuery
{
    private $_fleaMarkets = array();
    private $_offset = 0;
    private $_limit = 20;

    public function setOffset($offset)
    {
        $this->_offset = $offset;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets')
            ->limit($this->_limit)
            ->offset($this->_offset);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetchAll();
    }

    protected function mapResult($result)
    {
        $this->_fleaMarkets = array();

        if ($result === false) {
            return $this->_fleaMarkets;
        }

        foreach ($result as $item) {
            $fleaMarket = new FleaMarket();
            $fleaMarket
                ->setId($item['id'])
                ->setName($item['name'])
                ->setOrganizerId($item['organizer_id']);

            $this->_fleaMarkets[] = $fleaMarket;
        }

        return $this->_fleaMarkets;
    }
}
