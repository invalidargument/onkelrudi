<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class DatesInsertQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate[]
     */
    private $_dates;
    private $_fleaMakretId;

    public function setFleaMarketId($id)
    {
        $this->_fleaMakretId = $id;
        return $this;
    }

    /**
     * @param \RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate[] $dates
     * @return DatesInsertQuery
     */
    public function setDates($dates)
    {
        $this->_dates = $dates;
        return $this;
    }

    protected function runQuery()
    {
        // TODO start transaction

        foreach ($this->_dates as $date) {
            $insertStatement = $this->pdo
                ->insert(
                    array('fleamarket_id', 'start', 'end')
                )
                ->into('fleamarkets_dates')
                ->values(
                    array($this->_fleaMakretId, $date->getStart(), $date->getEnd())
                );

            $insertStatement->execute();
        }

        // TODO commit transaction

        return 1;
    }
}
