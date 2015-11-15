<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class FleaMarketOrganizerInsertQuery extends AbstractInsertQuery
{
    private $_name;
    private $_street;
    private $_streetNo;
    private $_zipCode;
    private $_city;
    private $_phone;
    private $_url;

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

    public function run()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('name', 'street', 'streetno', 'city', 'zipcode', 'phone', 'url')
            )
            ->into('fleamarkets_organizer')
            ->values(
                array($this->_name, $this->_street, $this->_streetNo, $this->_city, $this->_zipCode, $this->_phone, $this->_url)
            );

        return $insertStatement->execute();
    }
}
