<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class DatesDeleteQuery extends AbstractInsertQuery
{
    private $_fleaMarketId;

    public function setFleaMarketId($id)
    {
        $this->_fleaMarketId = $id;
        return $this;
    }

    protected function runQuery()
    {
        $deleteStatement = $this->pdo
            ->delete()
            ->from('fleamarkets_dates')
            ->where('fleamarket_id', '=', $this->_fleaMarketId);

        return $deleteStatement->execute();
    }
}