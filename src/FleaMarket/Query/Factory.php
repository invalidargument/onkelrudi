<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class Factory
{
    private $_fleaMarketQuery;

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery
     */
    public function createFleaMarketQuery()
    {
        if (is_null($this->_fleaMarketQuery)) {
            $this->_fleaMarketQuery = new FleaMarketOrganizerInsertQuery();
        }

        return $this->_fleaMarketQuery;
    }
}
