<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Ramsey\Uuid\Uuid;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class FleaMarketInsertQuery extends AbstractInsertQuery
{
    private $_uuid;
    private $_organizerId;
    private $_userId;
    private $_name;
    private $_description;
    private $_dates;
    private $_street;
    private $_streetNo;
    private $_city;
    private $_zipCode;
    private $_location;
    private $_url;
    private $_approved;
    private $_fleaMarketService;

    /**
     * @param FleaMarketService $fleaMarketService
     * @return FleaMarketInsertQuery
     */
    public function setFleaMarketService(FleaMarketService $fleaMarketService)
    {
        $this->_fleaMarketService = $fleaMarketService;
        return $this;
    }

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

    public function setUserId($userId)
    {
        $this->_userId = $userId;
        return $this;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
        return $this;
    }

    /**
     * @param FleaMarketDate[] $dates
     * @return FleaMarketInsertQuery
     */
    public function setDates(array $dates)
    {
        $this->_dates = $dates;
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

    public function setApproved($approved)
    {
        $this->_approved = (boolean) $approved;
    }

    private function _getApproved()
    {
        if (!$this->_approved) {
            return 0;
        }

        return intval($this->_approved);
    }

    public function getUuid()
    {
        return Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            $this->_name.$this->_zipCode.$this->_url.$this->_street.$this->_streetNo.$this->_city.$this->_description.$this->_location.$this->_organizerId
        )->toString();
    }

    protected function runQuery()
    {
        $date = new \DateTime(date('Y-m-d H:i:s'));

        $this->pdo->beginTransaction();

        $insertStatement = $this->pdo
            ->insert(
                array('uuid', 'organizer_id', 'user_id', 'name', 'description', 'street', 'streetno', 'city', 'zipcode', 'location', 'url', 'approved', 'opt_in_dsgvo', 'opt_in_dsgvo_ts')
            )
            ->into('fleamarkets')
            ->values(
                array($this->getUuid(), $this->_organizerId, $this->_userId, $this->_name, $this->_description, $this->_street, $this->_streetNo, $this->_city, $this->_zipCode, $this->_location, $this->_url, $this->_getApproved(), true, $date->format('Y-m-d H:i:s'))
            );

        $fleaMarketId = $insertStatement->execute();

        $this->_fleaMarketService->createDates($fleaMarketId, $this->_dates);

        $this->pdo->commit();

        return $fleaMarketId;
    }
}
