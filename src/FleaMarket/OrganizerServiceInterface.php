<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

interface OrganizerServiceInterface
{
    public function getAllOrganizers();

    public function createOrganizer(OrganizerInterface $organizer);

    public function updateOrganizer(OrganizerInterface $organizer);

    public function deleteOrganizer(OrganizerInterface $organizer);

    public function getOrganizer($organizerId);

    public function getOrganizerByUserId($userId);
}
