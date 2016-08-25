<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\Query\AbstractQuery;

class DatesReadListQuery extends AbstractQuery
{
    private $_fleaMarketId;
    private $_onlyCurrentDates = false;

    public function setFleaMarketId($fleaMarketId)
    {
        $this->_fleaMarketId = $fleaMarketId;
        return $this;
    }

    public function setQueryOnlyCurrentDates($onlyCurrentDates = true)
    {
        $this->_onlyCurrentDates = $onlyCurrentDates;
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
            ->distinct()
            ->from('fleamarkets_dates')
            ->orderBy('start', 'ASC');

        if ($this->_fleaMarketId) {
            $selectStatement = $selectStatement->where('fleamarket_id', '=', $this->_fleaMarketId);
        }

        if ($this->_onlyCurrentDates) {
            $selectStatement = $selectStatement->where('start', '>=', date('Y-m-d 00:00:00'));
        }

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetchAll();
    }
}
