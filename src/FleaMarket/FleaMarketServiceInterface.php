<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\ServiceInterface;

interface FleaMarketServiceInterface extends ServiceInterface
{
    public function getAllFleaMarkets();

    public function getFleaMarkets($limit, $offset);

    public function getAllOrganizers();

    public function getFleaMarket($id);

    public function updateFleaMarket(FleaMarketInterface $fleaMarket);

    public function deleteFleaMarket(FleaMarketInterface $fleaMarket);

    public function createFleaMarket(FleaMarketInterface $fleaMarket);

    public function createOrganizer(OrganizerInterface $organizer);

    public function updateOrganizer(OrganizerInterface $organizer);

    public function deleteOrganizer(OrganizerInterface $organizer);

    public function getOrganizer($id);
}
