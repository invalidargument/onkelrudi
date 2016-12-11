<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\ServiceInterface;
use RudiBieller\OnkelRudi\User\UserInterface;

interface FleaMarketServiceInterface extends ServiceInterface
{
    public function getAllFleaMarkets();

    public function getAllFleaMarketsByTimespan(\DateTimeImmutable $start = null, \DateTimeImmutable $end = null, $onlyApproved = true);

    public function getFleaMarkets($limit, $offset);

    public function getFleaMarketsByUser(UserInterface $user, $limit, $offset);

    public function getFleaMarket($id);

    public function updateFleaMarket(FleaMarketInterface $fleaMarket);

    public function deleteFleaMarket(FleaMarketInterface $fleaMarket);

    public function createFleaMarket(FleaMarketInterface $fleaMarket, $approved = false);

    /**
     * @param int $fleaMarketId
     * @param FleaMarketDate[] $dates
     * @return boolean
     */
    public function createDates($fleaMarketId, array $dates);

    /**
     * @param int $fleaMarketId
     * @param bool $onlyUpcoming
     * @return FleaMarketDate[]
     */
    public function getDates($fleaMarketId, $onlyUpcoming = false);

    public function deleteDates($fleaMarketId);

    /**
     * @return FleaMarketDate[]
     */
    public function getAllUpcomingDates();
}
