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
    private $_onlyCurrentDates = false;
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

    public function setQueryOnlyCurrentDates($onlyCurrentDates = true)
    {
        $this->_onlyCurrentDates = $onlyCurrentDates;
    }

    protected function runQuery()
    {
        // TODO optimize to fetch all dates for later use as well
        $validMarketsStmt = $this->pdo
            ->select(['fleamarket_id'])
            ->from('fleamarkets_dates')
            ->groupBy('fleamarket_id');

        if ($this->_onlyCurrentDates) {
            $validMarketsStmt->where('start', '>=', date('Y-m-d 00:00:00'));
        }

        $validFleaMarkets = $validMarketsStmt->execute()->fetchAll(\PDO::FETCH_COLUMN);

        if (count($validFleaMarkets) === 0) {
            return array();
        }

        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets')
            ->whereIn('id', $validFleaMarkets)
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
            $dates = $this->_fleaMarketService->getDates($item['id'], $this->_onlyCurrentDates);

            if (count($dates) > 0) {
                $fleaMarket = new FleaMarket();
                $fleaMarket
                    ->setId($item['id'])
                    ->setUuid($item['uuid'])
                    ->setName($item['name'])
                    ->setSlug((new Slugify())->slugify($item['name']))
                    ->setDescription($item['description'])
                    ->setDates($dates)
                    ->setStreet($item['street'])
                    ->setStreetNo($item['streetno'])
                    ->setCity($item['city'])
                    ->setZipCode($item['zipcode'])
                    ->setLocation($item['location'])
                    ->setUrl($item['url']);

                $this->_fleaMarkets[] = $fleaMarket;
            }
        }

        usort(
            $this->_fleaMarkets,
            array($this, '_sortFleaMarketsByDates')
        );

        return $this->_fleaMarkets;
    }

    private function _sortFleaMarketsByDates($a, $b)
    {
        $dates1 = $a->getDates();
        $dates2 = $b->getDates();

        if (count($dates1) === 0 || count($dates2) === 0) {
            return 0;
        }

        if ($dates1[0]->getStart() == $dates2[0]->getStart()) {
            return 0;
        }

        if ($dates1[0]->getStart() < $dates2[0]->getStart()) {
            return -1;
        }

        return 1;
    }
}
