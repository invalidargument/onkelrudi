<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\ServiceInterface;
use RudiBieller\OnkelRudi\User\UserInterface;

interface FleaMarketServiceInterface extends ServiceInterface
{
    public function getAllFleaMarkets();

    public function getAllUpcomingFleaMarkets();

    public function getFleaMarkets($limit, $offset);

    public function getFleaMarketsByUser(UserInterface $user, $limit, $offset);

    public function getFleaMarket($id);

    public function updateFleaMarket(FleaMarketInterface $fleaMarket);

    public function deleteFleaMarket(FleaMarketInterface $fleaMarket);

    public function createFleaMarket(FleaMarketInterface $fleaMarket);

    /**
     * @param int $fleaMarketId
     * @param FleaMarketDate[] $dates
     * @return boolean
     */
    public function createDates($fleaMarketId, array $dates);

    /**
     * @param int $fleaMarketId
     * @return FleaMarketDate[]
     */
    public function getDates($fleaMarketId);
}
