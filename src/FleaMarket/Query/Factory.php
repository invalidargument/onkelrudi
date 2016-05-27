<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Slim\Container;

class Factory
{
    private $_fleaMarketDeleteQuery;
    private $_fleaMarketInsertQuery;
    private $_fleaMarketReadListQuery;
    private $_fleaMarketReadQuery;
    private $_fleaMarketUpdateQuery;
    private $_fleaMarketTestCaseDeleteQuery;
    private $_datesInsertQuery;
    private $_datesReadListQuery;

    private $_diContainer;

    public function setDiContainer(Container $diContainer)
    {
        $this->_diContainer = $diContainer;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDeleteQuery
     */
    public function createFleaMarketDeleteQuery()
    {
        if (is_null($this->_fleaMarketDeleteQuery)) {
            $this->_fleaMarketDeleteQuery = new FleaMarketDeleteQuery();
            $this->_fleaMarketDeleteQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketInsertQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketReadListQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketReadQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketUpdateQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketTestCaseDeleteQuery->setDiContainer($this->_diContainer);
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
            $this->_datesInsertQuery->setDiContainer($this->_diContainer);
        }

        return $this->_datesInsertQuery;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\DatesReadListQuery
     */
    public function createFleaMarketDatesReadListQuery()
    {
        if (is_null($this->_datesReadListQuery)) {
            $this->_datesReadListQuery = new DatesReadListQuery();
            $this->_datesReadListQuery->setDiContainer($this->_diContainer);
        }

        return $this->_datesReadListQuery;
    }
}
