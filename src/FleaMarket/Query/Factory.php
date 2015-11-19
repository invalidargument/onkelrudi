<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class Factory
{
    private $_fleaMarketDeleteQuery;
    private $_fleaMarketInsertQuery;
    private $_fleaMarketReadListQuery;
    private $_fleaMarketReadQuery;
    private $_fleaMarketUpdateQuery;
    private $_fleaMarketOrganizerDeleteQuery;
    private $_fleaMarketOrganizerInsertQuery;
    private $_fleaMarketOrganizerReadListQuery;
    private $_fleaMarketOrganizerReadQuery;
    private $_fleaMarketOrganizerUpdateQuery;
    private $_fleaMarketDetailsDeleteQuery;
    private $_fleaMarketDetailsInsertQuery;
    private $_fleaMarketDetailsReadListQuery;
    private $_fleaMarketDetailsReadQuery;
    private $_fleaMarketDetailsUpdateQuery;

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

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsDeleteQuery
     */
    public function createFleaMarketDetailsDeleteQuery()
    {
        if (is_null($this->_fleaMarketDetailsDeleteQuery)) {
            $this->_fleaMarketDetailsDeleteQuery = new FleaMarketDetailsDeleteQuery();
        }

        return $this->_fleaMarketDetailsDeleteQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsInsertQuery
     */
    public function createFleaMarketDetailsInsertQuery()
    {
        if (is_null($this->_fleaMarketDetailsInsertQuery)) {
            $this->_fleaMarketDetailsInsertQuery = new FleaMarketDetailsInsertQuery();
        }

        return $this->_fleaMarketDetailsInsertQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsReadListQuery
     */
    public function createFleaMarketDetailsReadListQuery()
    {
        if (is_null($this->_fleaMarketDetailsReadListQuery)) {
            $this->_fleaMarketDetailsReadListQuery = new FleaMarketDetailsReadListQuery();
        }

        return $this->_fleaMarketDetailsReadListQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsReadQuery
     */
    public function createFleaMarketDetailsReadQuery()
    {
        if (is_null($this->_fleaMarketDetailsReadQuery)) {
            $this->_fleaMarketDetailsReadQuery = new FleaMarketDetailsReadQuery();
        }

        return $this->_fleaMarketDetailsReadQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsUpdateQuery
     */
    public function createFleaMarketDetailsUpdateQuery()
    {
        if (is_null($this->_fleaMarketDetailsUpdateQuery)) {
            $this->_fleaMarketDetailsUpdateQuery = new FleaMarketDetailsUpdateQuery();
        }

        return $this->_fleaMarketDetailsUpdateQuery;
    }
}
