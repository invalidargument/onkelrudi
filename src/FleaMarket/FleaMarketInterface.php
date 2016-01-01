<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

interface FleaMarketInterface
{
    public function getId();

    public function getOrganizer();

    public function getName();

    public function getDescription();

    public function getStart();

    public function getEnd();

    public function getStreet();

    public function getStreetNo();

    public function getCity();

    public function getZipCode();

    public function getLocation();

    public function getUrl();
}
