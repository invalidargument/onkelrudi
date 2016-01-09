<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

interface OrganizerInterface
{
    public function getId();

    public function getUuid();

    public function getName();

    public function getStreet();

    public function getStreetNo();

    public function getZipCode();

    public function getCity();

    public function getPhone();

    public function getUrl();
}
