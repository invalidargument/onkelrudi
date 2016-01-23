<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory;

class OrganizerService implements OrganizerServiceInterface
{
    const DEFAULT_ORGANIZER = 1;

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

    public function getOrganizer($id)
    {
        $query = $this->_factory->createFleaMarketOrganizerReadQuery();
        $query->setOrganizerId($id);

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
