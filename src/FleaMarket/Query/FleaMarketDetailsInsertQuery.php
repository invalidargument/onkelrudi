<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class FleaMarketDetailsInsertQuery extends AbstractInsertQuery
{
    private $_fleaMarketId;
    private $_description;
    private $_start;
    private $_end;
    private $_street;
    private $_streetNo;
    private $_city;
    private $_zipCode;
    private $_location;
    private $_url;

    public function setFleaMarketId($id)
    {
        $this->_fleaMarketId = $id;
        return $this;
    }

    public function getFleaMarketId()
    {
        return $this->_fleaMarketId;
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

    public function runQuery()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('fleamarket_id', 'description', 'start', 'end', 'street', 'streetno', 'city', 'zipcode', 'location', 'url')
            )
            ->into('fleamarkets_details')
            ->values(
                array($this->_fleaMarketId, $this->_description, $this->_start, $this->_end, $this->_street, $this->_streetNo, $this->_city, $this->_zipCode, $this->_location, $this->_url)
            );

        return $insertStatement->execute();
    }
}
