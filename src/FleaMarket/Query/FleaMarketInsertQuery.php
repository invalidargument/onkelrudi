<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Ramsey\Uuid\Uuid;
use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class FleaMarketInsertQuery extends AbstractInsertQuery
{
    private $_uuid;
    private $_organizerId;
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

    public function setUuid($uuid)
    {
        $this->_uuid = $uuid;
        return $this;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function setOrganizerId($id)
    {
        $this->_organizerId = $id;
        return $this;
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

    public function getUuid()
    {
        return Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            $this->_name.$this->_zipCode.$this->_url.$this->_street.$this->_streetNo.$this->_city.$this->_description.$this->_start.$this->_end.$this->_location.$this->_organizerId
        )->toString();
    }

    protected function runQuery()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('uuid', 'organizer_id', 'name', 'description', 'start', 'end', 'street', 'streetno', 'city', 'zipcode', 'location', 'url')
            )
            ->into('fleamarkets')
            ->values(
                array($this->getUuid(), $this->_organizerId, $this->_name, $this->_description, $this->_start, $this->_end, $this->_street, $this->_streetNo, $this->_city, $this->_zipCode, $this->_location, $this->_url)
            );

        return $insertStatement->execute();
    }
}
