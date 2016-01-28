<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\Query\AbstractQuery;

class DatesReadListQuery extends AbstractQuery
{
    private $_fleaMarketId;

    public function setFleaMarketId($fleaMarketId)
    {
        $this->_fleaMarketId = $fleaMarketId;
        return $this;
    }

    protected function mapResult($result)
    {
        $dates = array();

        if ($result === false) {
            return $dates;
        }

        foreach ($result as $item) {
            $dates[] = new FleaMarketDate(
                $item['start'],
                $item['end']
            );
        }

        return $dates;
    }

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_dates')
            ->where('fleamarket_id', '=', $this->_fleaMarketId)
            ->orderBy('start', 'ASC');

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetchAll();
    }
}
