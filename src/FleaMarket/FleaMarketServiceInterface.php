<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\ServiceInterface;

interface FleaMarketServiceInterface extends ServiceInterface
{
    function getAllFleaMarkets();

    function getFleaMarkets($limit, $offset);

    function getAllOrganizers();

    function getFleaMarket($id);

    function updateFleaMarket(FleaMarketInterface $fleaMarket);

    function deleteFleaMarket(FleaMarketInterface $fleaMarket);

    function createFleaMarket(FleaMarketInterface $fleaMarket);

    function createOrganizer(OrganizerInterface $organizer);

    function updateOrganizer(OrganizerInterface $organizer);

    function deleteOrganizer(OrganizerInterface $organizer);

    function getOrganizer($id);
}
