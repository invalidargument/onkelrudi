<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\ServiceInterface;

interface FleaMarketServiceInterface extends ServiceInterface
{
    public function getAllFleaMarkets();

    public function getFleaMarkets($limit, $offset);

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
}
