<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarket implements FleaMarketInterface, \JsonSerializable
{
    private $_id;
    private $_uuid;
    private $_organizer;
    private $_name;
    private $_slug;
    private $_description;
    /**
     * @var FleaMarketDate[]
     */
    private $_dates = [];
    private $_street;
    private $_streetNo;
    private $_city;
    private $_zipCode;
    private $_location;
    private $_url;

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getOrganizer()
    {
        return $this->_organizer;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setOrganizer($organizer)
    {
        $this->_organizer = $organizer;
        return $this;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getStreet()
    {
        return $this->_street;
    }

    public function getStreetNo()
    {
        return $this->_streetNo;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function getZipCode()
    {
        return $this->_zipCode;
    }

    public function getLocation()
    {
        return $this->_location;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
        return $this;
    }

    public function setStreet($street)
    {
        $this->_street = $street;
        return $this;
    }

    public function setStreetNo($streetNo)
    {
        $this->_streetNo = $streetNo;
        return $this;
    }

    public function setCity($city)
    {
        $this->_city = $city;
        return $this;
    }

    public function setZipCode($zipCode)
    {
        $this->_zipCode = $zipCode;
        return $this;
    }

    public function setLocation($location)
    {
        $this->_location = $location;
        return $this;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->_slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->_slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->_uuid;
    }

    /**
     * @param string $uuid
     * @return FleaMarket
     */
    public function setUuid($uuid)
    {
        $this->_uuid = $uuid;
        return $this;
    }

    /**
     * @return FleaMarketDate[]
     */
    public function getDates()
    {
        return $this->_dates;
    }

    /**
     * @param FleaMarketDate[] $dates
     * @return FleaMarket
     */
    public function setDates($dates)
    {
        $this->_dates = $dates;
        return $this;
    }

    public function addDate(FleaMarketDate $date)
    {
        $this->_dates[] = $date;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'uuid' => $this->getUuid(),
            'organizer' => $this->getOrganizer(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'dates' => $this->getDates(),
            'street' => $this->getStreet(),
            'streetNo' => $this->getStreetNo(),
            'city' => $this->getCity(),
            'zipCode' => $this->getZipCode(),
            'location' => $this->getLocation(),
            'url' => $this->getUrl()
        ];
    }
}
