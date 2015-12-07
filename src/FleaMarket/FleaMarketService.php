<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;

class FleaMarketService implements FleaMarketServiceInterface
{
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

        $query
            ->setName($fleaMarket->getName())
            ->setDescription($fleaMarket->getDescription())
            ->setStart($fleaMarket->getStart())
            ->setEnd($fleaMarket->getEnd())
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

    public function createOrganizer(OrganizerInterface $organizer)
    {
        $query = $this->_factory->createFleaMarketOrganizerInsertQuery();

        $query->setName($organizer->getName())
            ->setStreet($organizer->getStreet())
            ->setStreetNo($organizer->getStreetNo())
            ->setZipCode($organizer->getZipCode())
            ->setCity($organizer->getCity())
            ->setPhone($organizer->getPhone())
            ->setUrl($organizer->getUrl());

        $id = $query->run();
        $organizer->setId($id);

        return $id;
    }

    public function deleteFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $query = $this->_factory->createFleaMarketDeleteQuery();
        $query->setFleaMarket($fleaMarket);

        return $query->run();
    }

    public function deleteOrganizer(OrganizerInterface $organizer)
    {
        $query = $this->_factory->createFleaMarketOrganizerDeleteQuery();
        $query->setOrganizer($organizer);

        return $query->run();
    }

    public function getAllFleaMarkets()
    {
        $query = $this->_factory->createFleaMarketReadListQuery();

        return $query->run();
    }

    public function getFleaMarket($id)
    {
        $query = $this->_factory->createFleaMarketReadQuery();
        $query->setFleaMarketId($id);

        return $query->run();
    }

    public function getOrganizer($id)
    {
        $query = $this->_factory->createFleaMarketOrganizerReadQuery();
        $query->setOrganizerId($id);

        return $query->run();
    }

    public function updateFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $query = $this->_factory->createFleaMarketUpdateQuery();
        $query->setFleaMarket($fleaMarket);

        return $query->run();
    }

    public function updateOrganizer(OrganizerInterface $organizer)
    {
        $query = $this->_factory->createFleaMarketOrganizerUpdateQuery();
        $query->setOrganizer($organizer);

        return $query->run();
    }
}
