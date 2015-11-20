<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class Organizer implements OrganizerInterface
{
    private $_id;
    private $_name;
    private $_street;
    private $_streetNo;
    private $_zipCode;
    private $_city;
    private $_phone;
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

    public function getName()
    {
        return $this->_name;
    }

    public function getStreet()
    {
        return $this->_street;
    }

    public function getStreetNo()
    {
        return $this->_streetNo;
    }

    public function getZipCode()
    {
        return $this->_zipCode;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function getUrl()
    {
        return $this->_url;
    }

        public function setName($name)
    {
        $this->_name = $name;
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

    public function setZipCode($zipCode)
    {
        $this->_zipCode = $zipCode;
        return $this;
    }

    public function setCity($city)
    {
        $this->_city = $city;
        return $this;
    }

    public function setPhone($phone)
    {
        $this->_phone = $phone;
        return $this;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }
}