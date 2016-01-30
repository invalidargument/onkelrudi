<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

interface FleaMarketInterface
{
    public function getId();

    public function getUuid();

    public function getOrganizer();

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
