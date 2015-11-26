<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

interface FleaMarketInterface
{
    function getId();

    function getOrganizer();

    function getName();

    function getDescription();

    function getStart();

    function getEnd();

    function getStreet();

    function getStreetNo();

    function getCity();

    function getZipCode();

    function getLocation();

    function getUrl();
}
