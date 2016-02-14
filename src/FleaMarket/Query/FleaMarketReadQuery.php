<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Cocur\Slugify\Slugify;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class FleaMarketReadQuery extends AbstractQuery
{
    private $_fleaMarketId;
    private $_fleaMarketService;
    private $_dates = [];

    public function setFleaMarketId($fleaMarketId)
    {
        $this->_fleaMarketId = $fleaMarketId;
        return $this;
    }

    public function setFleaMarketService(FleaMarketServiceInterface $service)
    {
        $this->_fleaMarketService = $service;
        return $this;
    }

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets')
            ->where('id', '=', $this->_fleaMarketId);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        $this->_dates = $this->_fleaMarketService->getDates($this->_fleaMarketId);

        return $result;
    }

    protected function mapResult($result)
    {
        if ($result === false) {
            return null;
        }

        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarket = new FleaMarket();
        $organizer = new Organizer();
        $organizer->setId($result['organizer_id']);

        $fleaMarket
            ->setId($result['id'])
            ->setUuid($result['uuid'])
            ->setName($result['name'])
            ->setSlug((new Slugify())->slugify($result['name']))
            ->setDescription($result['description'])
            ->setDates($this->_dates)
            ->setStreet($result['street'])
            ->setStreetNo($result['streetno'])
            ->setCity($result['city'])
            ->setZipCode($result['zipcode'])
            ->setLocation($result['location'])
            ->setUrl($result['url'])
            ->setOrganizer($organizer);

        return $fleaMarket;
    }
}
