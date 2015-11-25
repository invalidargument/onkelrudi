<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;

class FleaMarketService implements FleaMarketServiceInterface
{
    private $_factory;

    public function setQueryFactory(Factory $factory)
    {
        $this->_factory = $factory;
    }

    public function createFleaMarket(FleaMarketInterface $fleaMarket, FleaMarketDetailsInterface $details, OrganizerInterface $organizer)
    {
        $deteailsQuery = $this->_factory->createFleaMarketDetailsInsertQuery();
        $query = $this->_factory->createFleaMarketInsertQuery();

        $query->setName($fleaMarket->getName())
            ->setOrganizerId($organizer->getId());

        $fleaMarketId = $query->run();
        $fleaMarket->setId($fleaMarketId);

        $deteailsQuery->setFleaMarketId($fleaMarketId)
            ->setDescription($details->getDescription())
            ->setStart($details->getStart())
            ->setEnd($details->getEnd())
            ->setStreet($details->getStreet())
            ->setStreetNo($details->getStreetNo())
            ->setCity($details->getCity())
            ->setZipCode($details->getZipCode())
            ->setLocation($details->getLocation())
            ->setUrl($details->getUrl());

        $detailsId = $deteailsQuery->run();
        $details->setId($detailsId)
            ->setFleaMarketId($fleaMarketId);

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

    public function updateFleaMarket(FleaMarketInterface $fleaMarket, FleaMarketDetailsInterface $details, OrganizerInterface $organizer)
    {
        // consider a transaction
        $query = $this->_factory->createFleaMarketUpdateQuery();
        $query->setFleaMarket($fleaMarket)
            ->run();

        $detailsQuery = $this->_factory->createFleaMarketDetailsUpdateQuery();
        $detailsQuery->setDetails($details)
            ->run();

        $organizerQuery = $this->_factory->createFleaMarketOrganizerUpdateQuery();
        $organizerQuery->setOrganizer($organizer)
            ->run();

        return 1;
    }

    public function updateOrganizer(OrganizerInterface $organizer)
    {
        $query = $this->_factory->createFleaMarketOrganizerUpdateQuery();
        $query->setOrganizer($organizer);

        return $query->run();
    }
}
