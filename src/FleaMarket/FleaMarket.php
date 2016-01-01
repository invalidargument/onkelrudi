<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarket implements FleaMarketInterface, \JsonSerializable
{
    private $_id;
    private $_organizer;
    private $_name;
    private $_description;
    private $_start;
    private $_end;
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

    public function getStart()
    {
        return $this->_start;
    }

    public function getEnd()
    {
        return $this->_end;
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

    public function setStart($start)
    {
        $this->_start = $start;
        return $this;
    }

    public function setEnd($end)
    {
        $this->_end = $end;
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'organizer' => $this->getOrganizer(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'street' => $this->getStreet(),
            'streetNo' => $this->getStreetNo(),
            'city' => $this->getCity(),
            'zipCode' => $this->getZipCode(),
            'location' => $this->getLocation(),
            'url' => $this->getUrl()
        ];
    }
}
