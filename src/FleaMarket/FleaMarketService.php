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

        return $query->run();
    }

    public function deleteFleaMarket(FleaMarketInterface $fleaMarket)
    {

    }

    public function deleteOrganizer(OrganizerInterface $organizer)
    {

    }

    public function getAllFleaMarkets()
    {

    }

    public function getFleaMarket($id)
    {

    }

    public function getOrganizer($id)
    {

    }

    public function updateFleaMarket(FleaMarketInterface $fleaMarket, FleaMarketDetailsInterface $details, OrganizerInterface $organizer)
    {

    }

    public function updateOrganizer(OrganizerInterface $organizer)
    {

    }

}
