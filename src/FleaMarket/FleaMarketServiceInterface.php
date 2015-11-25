<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

interface FleaMarketServiceInterface
{
    function getAllFleaMarkets();

    function getFleaMarket($id);

    function updateFleaMarket(FleaMarketInterface $fleaMarket, FleaMarketDetailsInterface $details, OrganizerInterface $organizer);

    function deleteFleaMarket(FleaMarketInterface $fleaMarket);

    function createFleaMarket(FleaMarketInterface $fleaMarket, FleaMarketDetailsInterface $details, OrganizerInterface $organizer);

    function createOrganizer(OrganizerInterface $organizer);

    function updateOrganizer(OrganizerInterface $organizer);

    function deleteOrganizer(OrganizerInterface $organizer);

    function getOrganizer($id);
}
