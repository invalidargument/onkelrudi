<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class OrganizerQueryFactory
{
    private $_fleaMarketOrganizerDeleteQuery;
    private $_fleaMarketOrganizerInsertQuery;
    private $_fleaMarketOrganizerReadListQuery;
    private $_fleaMarketOrganizerReadQuery;
    private $_fleaMarketOrganizerUpdateQuery;

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerDeleteQuery
     */
    public function createFleaMarketOrganizerDeleteQuery()
    {
        if (is_null($this->_fleaMarketOrganizerDeleteQuery)) {
            $this->_fleaMarketOrganizerDeleteQuery = new FleaMarketOrganizerDeleteQuery();
        }

        return $this->_fleaMarketOrganizerDeleteQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery
     */
    public function createFleaMarketOrganizerInsertQuery()
    {
        if (is_null($this->_fleaMarketOrganizerInsertQuery)) {
            $this->_fleaMarketOrganizerInsertQuery = new FleaMarketOrganizerInsertQuery();
        }

        return $this->_fleaMarketOrganizerInsertQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadListQuery
     */
    public function createFleaMarketOrganizerReadListQuery()
    {
        if (is_null($this->_fleaMarketOrganizerReadListQuery)) {
            $this->_fleaMarketOrganizerReadListQuery = new FleaMarketOrganizerReadListQuery();
        }

        return $this->_fleaMarketOrganizerReadListQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadQuery
     */
    public function createFleaMarketOrganizerReadQuery()
    {
        if (is_null($this->_fleaMarketOrganizerReadQuery)) {
            $this->_fleaMarketOrganizerReadQuery = new FleaMarketOrganizerReadQuery();
        }

        return $this->_fleaMarketOrganizerReadQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerUpdateQuery
     */
    public function createFleaMarketOrganizerUpdateQuery()
    {
        if (is_null($this->_fleaMarketOrganizerUpdateQuery)) {
            $this->_fleaMarketOrganizerUpdateQuery = new FleaMarketOrganizerUpdateQuery();
        }

        return $this->_fleaMarketOrganizerUpdateQuery;
    }
}
