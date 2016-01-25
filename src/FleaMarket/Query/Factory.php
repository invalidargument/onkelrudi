<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class Factory
{
    private $_fleaMarketDeleteQuery;
    private $_fleaMarketInsertQuery;
    private $_fleaMarketReadListQuery;
    private $_fleaMarketReadQuery;
    private $_fleaMarketUpdateQuery;
    private $_fleaMarketTestCaseDeleteQuery;
    private $_datesInsertQuery;

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDeleteQuery
     */
    public function createFleaMarketDeleteQuery()
    {
        if (is_null($this->_fleaMarketDeleteQuery)) {
            $this->_fleaMarketDeleteQuery = new FleaMarketDeleteQuery();
        }

        return $this->_fleaMarketDeleteQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketInsertQuery
     */
    public function createFleaMarketInsertQuery()
    {
        if (is_null($this->_fleaMarketInsertQuery)) {
            $this->_fleaMarketInsertQuery = new FleaMarketInsertQuery();
        }

        return $this->_fleaMarketInsertQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadListQuery
     */
    public function createFleaMarketReadListQuery()
    {
        if (is_null($this->_fleaMarketReadListQuery)) {
            $this->_fleaMarketReadListQuery = new FleaMarketReadListQuery();
        }

        return $this->_fleaMarketReadListQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadQuery
     */
    public function createFleaMarketReadQuery()
    {
        if (is_null($this->_fleaMarketReadQuery)) {
            $this->_fleaMarketReadQuery = new FleaMarketReadQuery();
        }

        return $this->_fleaMarketReadQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketUpdateQuery
     */
    public function createFleaMarketUpdateQuery()
    {
        if (is_null($this->_fleaMarketUpdateQuery)) {
            $this->_fleaMarketUpdateQuery = new FleaMarketUpdateQuery();
        }

        return $this->_fleaMarketUpdateQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketTestCaseDeleteQuery
     */
    public function createFleaMarketTestCaseDeleteQuery()
    {
        if (is_null($this->_fleaMarketTestCaseDeleteQuery)) {
            $this->_fleaMarketTestCaseDeleteQuery = new FleaMarketTestCaseDeleteQuery();
        }

        return $this->_fleaMarketTestCaseDeleteQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\DatesInsertQuery
     */
    public function createFleaMarketDatesInsertQuery()
    {
        if (is_null($this->_datesInsertQuery)) {
            $this->_datesInsertQuery = new DatesInsertQuery();
        }

        return $this->_datesInsertQuery;
    }
}
