<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;

class FleaMarketService implements FleaMarketServiceInterface
{
    const DEFAULT_ORGANIZER = 1;

    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\Query\Factory
     */
    private $_factory;

    public function setQueryFactory(Factory $factory)
    {
        $this->_factory = $factory;
    }

    public function createFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $query = $this->_factory->createFleaMarketInsertQuery();

        $organizerId = is_null($fleaMarket->getOrganizer())
            ? self::DEFAULT_ORGANIZER
            : $fleaMarket->getOrganizer()->getId();

        $query
            ->setFleaMarketService($this)
            ->setUuid($fleaMarket->getUuid())
            ->setOrganizerId($organizerId)
            ->setName($fleaMarket->getName())
            ->setDescription($fleaMarket->getDescription())
            ->setDates($fleaMarket->getDates())
            ->setStreet($fleaMarket->getStreet())
            ->setStreetNo($fleaMarket->getStreetNo())
            ->setCity($fleaMarket->getCity())
            ->setZipCode($fleaMarket->getZipCode())
            ->setLocation($fleaMarket->getLocation())
            ->setUrl($fleaMarket->getUrl());

        $fleaMarketId = $query->run();
        $fleaMarket->setId($fleaMarketId);

        return $fleaMarketId;
    }

    public function deleteFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $query = $this->_factory->createFleaMarketDeleteQuery();
        $query->setFleaMarket($fleaMarket);

        return $query->run();
    }

    /**
     * @return FleaMarket[]
     */
    public function getAllFleaMarkets()
    {
        $query = $this->_factory->createFleaMarketReadListQuery();

        $query->setFleaMarketService($this);

        return $query->run();
    }

    public function getFleaMarkets($limit, $offset)
    {
        $query = $this->_factory->createFleaMarketReadListQuery();
        $query
            ->setFleaMarketService($this)
            ->setLimit($limit)
            ->setOffset($offset);

        return $query->run();
    }

    public function getFleaMarket($fleaMarketId)
    {
        $query = $this->_factory->createFleaMarketReadQuery();
        $query
            ->setFleaMarketService($this)
            ->setFleaMarketId($fleaMarketId);

        return $query->run();
    }

    public function updateFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $query = $this->_factory->createFleaMarketUpdateQuery();
        $query->setFleaMarket($fleaMarket);

        return $query->run();
    }

    public function truncateTablesForTestCases()
    {
        $query = $this->_factory->createFleaMarketTestCaseDeleteQuery();
        return $query->run();
    }

    public function createDates($fleaMarketId, array $dates)
    {
        $query = $this->_factory->createFleaMarketDatesInsertQuery();
        $query
            ->setFleaMarketId($fleaMarketId)
            ->setDates($dates);

        return $query->run();
    }

    public function getDates($fleaMarketId)
    {
        $query = $this->_factory->createFleaMarketDatesReadListQuery();
        $query
            ->setFleaMarketId($fleaMarketId);

        return $query->run();
    }
}
