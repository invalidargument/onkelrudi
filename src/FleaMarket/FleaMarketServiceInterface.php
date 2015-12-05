<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\ServiceInterface;

interface FleaMarketServiceInterface extends ServiceInterface
{
    function getAllFleaMarkets();

    function getFleaMarket($id);

    function updateFleaMarket(FleaMarketInterface $fleaMarket, OrganizerInterface $organizer);

    function deleteFleaMarket(FleaMarketInterface $fleaMarket);

    function createFleaMarket(FleaMarketInterface $fleaMarket, OrganizerInterface $organizer);

    function createOrganizer(OrganizerInterface $organizer);

    function updateOrganizer(OrganizerInterface $organizer);

    function deleteOrganizer(OrganizerInterface $organizer);

    function getOrganizer($id);
}
