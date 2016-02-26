<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Ramsey\Uuid\Uuid;
use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class FleaMarketOrganizerInsertQuery extends AbstractInsertQuery
{
    private $_uuid;
    private $_name;
    private $_street;
    private $_streetNo;
    private $_zipCode;
    private $_city;
    private $_phone;
    private $_email;
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

    public function getUuid()
    {
        return Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            $this->_name.$this->_city.$this->_phone.$this->_email.$this->_street.$this->_streetNo.$this->_url.$this->_zipCode
        )->toString();
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
     * @return FleaMarketOrganizerInsertQuery
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    protected function runQuery()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('uuid', 'name', 'street', 'streetno', 'city', 'zipcode', 'phone', 'email', 'url')
            )
            ->into('fleamarkets_organizer')
            ->values(
                array($this->getUuid(), $this->_name, $this->_street, $this->_streetNo, $this->_city, $this->_zipCode, $this->_phone, $this->_email, $this->_url)
            );

        return $insertStatement->execute();
    }
}
