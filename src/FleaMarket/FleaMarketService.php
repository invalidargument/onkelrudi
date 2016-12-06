<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\User\NotificationServiceInterface;
use RudiBieller\OnkelRudi\User\UserInterface;

class FleaMarketService implements FleaMarketServiceInterface
{
    const DEFAULT_ORGANIZER = 1;

    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\Query\Factory
     */
    private $_factory;

    /**
     * @var \RudiBieller\OnkelRudi\User\NotificationServiceInterface
     */
    private $_notificationService;

    public function setQueryFactory(Factory $factory)
    {
        $this->_factory = $factory;
    }

    public function setNotificationService(NotificationServiceInterface $notificationService)
    {
        $this->_notificationService = $notificationService;
    }

    public function createFleaMarket(FleaMarketInterface $fleaMarket, $approved = false)
    {
        $query = $this->_factory->createFleaMarketInsertQuery();

        $organizerId = is_null($fleaMarket->getOrganizer())
            ? self::DEFAULT_ORGANIZER
            : $fleaMarket->getOrganizer()->getId();

        $userId = is_null($fleaMarket->getUser())
            ? 'default'
            : $fleaMarket->getUser()->getIdentifier();

        $query
            ->setFleaMarketService($this)
            ->setUuid($fleaMarket->getUuid())
            ->setOrganizerId($organizerId)
            ->setUserId($userId)
            ->setName($fleaMarket->getName())
            ->setDescription($fleaMarket->getDescription())
            ->setDates($fleaMarket->getDates())
            ->setStreet($fleaMarket->getStreet())
            ->setStreetNo($fleaMarket->getStreetNo())
            ->setCity($fleaMarket->getCity())
            ->setZipCode($fleaMarket->getZipCode())
            ->setLocation($fleaMarket->getLocation())
            ->setUrl($fleaMarket->getUrl())
            ->setApproved($approved);

        $fleaMarketId = $query->run();
        $fleaMarket->setId($fleaMarketId);

        $this->_notificationService->sendFleaMarketCreatedNotification($fleaMarketId);

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

    /**
     * @return FleaMarket[]
     */
    public function getAllFleaMarketsByTimespan(\DateTimeImmutable $start = null, \DateTimeImmutable $end = null)
    {
        $query = $this->_factory->createFleaMarketReadListQuery();

        if (is_null($start)) {
            $start = new \DateTimeImmutable();
        }
        if (is_null($end)) {
            $end = new \DateTimeImmutable(
                $start->add(new \DateInterval('P1M'))->format('Y-m-t 23:59:59')
            );
        }

        $query->setFleaMarketService($this)
            ->setQueryTimespan($start, $end);

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

    public function getFleaMarketsByUser(UserInterface $user, $limit, $offset)
    {
        $query = $this->_factory->createFleaMarketReadListQuery();
        $query
            ->setFleaMarketService($this)
            ->setLimit($limit)
            ->setOffset($offset)
            ->setUser($user);

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
        $query->setFleaMarketService($this); // TODO: remove this and do it in factory
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

    public function getDates($fleaMarketId, $onlyUpcoming = false)
    {
        $query = $this->_factory->createFleaMarketDatesReadListQuery();
        $query
            ->setFleaMarketId($fleaMarketId)
            ->setQueryOnlyCurrentDates($onlyUpcoming);

        return $query->run();
    }

    public function deleteDates($fleaMarketId)
    {
        $query = $this->_factory->createFleaMarketDatesDeleteQuery();
        $query
            ->setFleaMarketId($fleaMarketId);

        return $query->run();
    }

    public function getAllUpcomingDates()
    {
        $query = $this->_factory->createFleaMarketDatesReadListQuery();
        $query
            ->setQueryOnlyCurrentDates(true);

        return $query->run();
    }
}
