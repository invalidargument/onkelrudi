<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\User\UserInterface;

interface FleaMarketInterface
{
    public function getId();

    public function getUuid();

    public function getOrganizer();

    /**
     * @return UserInterface
     */
    public function getUser();

    public function getName();

    public function getDescription();

    public function getDates();

    public function getStreet();

    public function getStreetNo();

    public function getCity();

    public function getZipCode();

    public function getLocation();

    public function getUrl();
}
