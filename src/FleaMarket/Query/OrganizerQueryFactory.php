<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Slim\Container;

class OrganizerQueryFactory
{
    private $_fleaMarketOrganizerDeleteQuery;
    private $_fleaMarketOrganizerInsertQuery;
    private $_fleaMarketOrganizerReadListQuery;
    private $_fleaMarketOrganizerReadQuery;
    private $_fleaMarketOrganizerUpdateQuery;

    private $_diContainer;

    public function setDiContainer(Container $diContainer)
    {
        $this->_diContainer = $diContainer;
    }

    /**
     * @return \RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerDeleteQuery
     */
    public function createFleaMarketOrganizerDeleteQuery()
    {
        if (is_null($this->_fleaMarketOrganizerDeleteQuery)) {
            $this->_fleaMarketOrganizerDeleteQuery = new FleaMarketOrganizerDeleteQuery();
            $this->_fleaMarketOrganizerDeleteQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketOrganizerInsertQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketOrganizerReadListQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketOrganizerReadQuery->setDiContainer($this->_diContainer);
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
            $this->_fleaMarketOrganizerUpdateQuery->setDiContainer($this->_diContainer);
        }

        return $this->_fleaMarketOrganizerUpdateQuery;
    }
}
