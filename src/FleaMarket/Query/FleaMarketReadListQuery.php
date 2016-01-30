<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Cocur\Slugify\Slugify;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface;
use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class FleaMarketReadListQuery extends AbstractQuery
{
    private $_fleaMarkets = array();
    private $_offset = 0;
    private $_limit = 20;
    /**
     * @var FleaMarketServiceInterface
     */
    private $_fleaMarketService;

    public function setOffset($offset)
    {
        $this->_offset = $offset;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    public function setFleaMarketService(FleaMarketServiceInterface $service)
    {
        $this->_fleaMarketService = $service;
        return $this;
    }

    protected function runQuery()
    {
        $upcomingFleaMarketsStatement = $this->pdo
            ->select(['fleamarket_id'])
            ->from('fleamarkets_dates')
            ->where('start', '>=', date('Y-m-d 00:00:00'))
            ->groupBy('fleamarket_id');
        $validFleaMarkets = array_values(
            $upcomingFleaMarketsStatement->execute()->fetch(\PDO::FETCH_ASSOC)
        );

        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets')
            ->whereIn('id', $validFleaMarkets)
            ->orderBy('start', 'ASC')
            ->limit($this->_limit)
            ->offset($this->_offset);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetchAll();
    }

    protected function mapResult($result)
    {
        $this->_fleaMarkets = array();

        if ($result === false) {
            return $this->_fleaMarkets;
        }

        foreach ($result as $item) {
            $fleaMarket = new FleaMarket();
            $fleaMarket
                ->setId($item['id'])
                ->setUuid($item['uuid'])
                ->setName($item['name'])
                ->setSlug((new Slugify())->slugify($item['name']))
                ->setDescription($item['description'])
                ->setStart($item['start'])
                ->setEnd($item['end'])
                ->setDates($this->_fleaMarketService->getDates($item['id']))
                ->setStreet($item['street'])
                ->setStreetNo($item['streetno'])
                ->setCity($item['city'])
                ->setZipCode($item['zipcode'])
                ->setLocation($item['location'])
                ->setUrl($item['url']);

            $this->_fleaMarkets[] = $fleaMarket;
        }

        return $this->_fleaMarkets;
    }
}
