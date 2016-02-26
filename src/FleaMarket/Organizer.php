<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class Organizer implements OrganizerInterface, \JsonSerializable
{
    private $_id;
    private $_uuid;
    private $_name;
    private $_slug;
    private $_street;
    private $_streetNo;
    private $_zipCode;
    private $_city;
    private $_phone;
    private $_email;
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

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->_slug;
    }

    /**
     * @param mixed $slug
     * @return Organizer
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
     * @return Organizer
     */
    public function setUuid($uuid)
    {
        $this->_uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $email
     * @return Organizer
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'street' => $this->getStreet(),
            'streetNo' => $this->getStreetNo(),
            'zipCode' => $this->getZipCode(),
            'city' => $this->getCity(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'url' => $this->getUrl()
        ];
    }
}
