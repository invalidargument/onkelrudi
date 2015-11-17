<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetails;

class FleaMarketDetailsReadListQuery extends AbstractQuery
{
    private $_list;
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

    public function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_details')
            ->limit($this->_limit)
            ->offset($this->_offset);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $this->mapResult($statement->fetchAll());
    }

    protected function mapResult($result)
    {
        $this->_list = array();

        if ($result === false) {
            return $this->_list;
        }

        foreach ($result as $item) {
            $fleaMarket = new FleaMarketDetails();
            $fleaMarket
                ->setId($item['id'])
                ->setFleaMarketId($item['fleamarket_id'])
                ->setDescription($item['description'])
                ->setStart($item['start'])
                ->setEnd($item['end'])
                ->setStreet($item['street'])
                ->setStreetNo($item['streetno'])
                ->setCity($item['city'])
                ->setZipCode($item['zipcode'])
                ->setLocation($item['location'])
                ->setUrl($item['url']);

            $this->_list[] = $fleaMarket;
        }

        return $this->_list;
    }
}
