<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory;

class OrganizerService implements OrganizerServiceInterface
{
    // TODO: put it where it belongs better than here... @see also FleaMarketService
    const DEFAULT_ORGANIZER = 228;

    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory
     */
    private $_factory;

    public function setQueryFactory(OrganizerQueryFactory $factory)
    {
        $this->_factory = $factory;
    }

    public function createOrganizer(OrganizerInterface $organizer)
    {
        $query = $this->_factory->createFleaMarketOrganizerInsertQuery();

        $query
            ->setUuid($organizer->getUuid())
            ->setName($organizer->getName())
            ->setStreet($organizer->getStreet())
            ->setStreetNo($organizer->getStreetNo())
            ->setZipCode($organizer->getZipCode())
            ->setCity($organizer->getCity())
            ->setPhone($organizer->getPhone())
            ->setEmail($organizer->getEmail())
            ->setUrl($organizer->getUrl());

        $id = $query->run();
        $organizer->setId($id);

        return $id;
    }

    public function deleteOrganizer(OrganizerInterface $organizer)
    {
        $query = $this->_factory->createFleaMarketOrganizerDeleteQuery();
        $query->setOrganizer($organizer);

        return $query->run();
    }

    public function getOrganizer($organizerId)
    {
        $query = $this->_factory->createFleaMarketOrganizerReadQuery();
        $query->setOrganizerId($organizerId);

        return $query->run();
    }

    public function getOrganizerByUserId($userId)
    {
        $query = $this->_factory->createFleaMarketOrganizerByUserReadQuery();
        $query->setUserId($userId);

        return $query->run();
    }

    public function updateOrganizer(OrganizerInterface $organizer)
    {
        $query = $this->_factory->createFleaMarketOrganizerUpdateQuery();
        $query->setOrganizer($organizer);

        return $query->run();
    }

    public function getAllOrganizers()
    {
        $query = $this->_factory->createFleaMarketOrganizerReadListQuery();

        return $query->run();
    }
}
