<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Cocur\Slugify\Slugify;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface;
//use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\User\User;
use RudiBieller\OnkelRudi\User\UserInterface;

class FleaMarketReadListQuery extends AbstractQuery
{
    private $_offset = 0;
    private $_limit = 51;
    /**
     * @var UserInterface
     */
    private $_user;
    private $_onlyCurrentDates = false;
    private $_queryTimespan;
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

    public function setUser(UserInterface $user)
    {
        $this->_user = $user;
        return $this;
    }

    public function setFleaMarketService(FleaMarketServiceInterface $service)
    {
        $this->_fleaMarketService = $service;
        return $this;
    }

    public function setQueryTimespan(\DateTimeImmutable $start, \DateTimeImmutable $end)
    {
        $this->_queryTimespan = ['start' => $start, 'end' => $end];
        return $this;
    }

    public function setQueryOnlyCurrentDates($onlyCurrentDates = true)
    {
        $this->_onlyCurrentDates = $onlyCurrentDates;
    }

    protected function runQuery()
    {
        $datesStatement = $this->pdo
            ->select()
            ->from('fleamarkets_dates')
            ->orderBy('start', 'ASC')
            ->limit($this->_limit)
            ->offset($this->_offset);

        if ($this->_onlyCurrentDates) {
            $datesStatement = $datesStatement->where('start', '>=', date('Y-m-d 00:00:00'));
        }

        $datesData = $datesStatement->execute()->fetchAll();

        if (count($datesData) === 0) {
            return false;
        }

        $fleaMarketIds = $this->_extractFleaMarketIds($datesData);

        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets')
            ->whereIn('id', $fleaMarketIds);

        if ($this->_user) {
            $selectStatement = $selectStatement->where('user_id', '=', $this->_user->getIdentifier());
        }

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();
        $fleaMarketData = $statement->fetchAll();

        return array(
            'fleaMarkets' => $fleaMarketData,
            'dates' => $datesData
        );
    }

    protected function mapResult($result)
    {
        $mappedMarkets = array();

        if ($result === false) {
            return array();
        }

        $marketData = array();
        foreach ($result['fleaMarkets'] as $item) {
            $marketData[$item['id']] = $item;
        }

        foreach ($result['dates'] as $item) {
            $date = new FleaMarketDate($item['start'], $item['end']);
            $slug = (new Slugify())->slugify(
                $marketData[$item['fleamarket_id']]['name'].'-'.$marketData[$item['fleamarket_id']]['city']
            );

            //$organizer = new Organizer();
            //$organizer->setId($marketData[$item['fleamarket_id']]['organizer_id']);

            $fleaMarket = new FleaMarket();
            $fleaMarket
                ->setId($item['fleamarket_id'])
                ->setUuid($marketData[$item['fleamarket_id']]['uuid'])
                //->setOrganizer($organizer)
                ->setUser(new User($marketData[$item['fleamarket_id']]['user_id']))
                ->setName($marketData[$item['fleamarket_id']]['name'])
                ->setSlug($slug)
                ->setDescription($marketData[$item['fleamarket_id']]['description'])
                ->setDates([$date])
                ->setStreet($marketData[$item['fleamarket_id']]['street'])
                ->setStreetNo($marketData[$item['fleamarket_id']]['streetno'])
                ->setCity($marketData[$item['fleamarket_id']]['city'])
                ->setZipCode($marketData[$item['fleamarket_id']]['zipcode'])
                ->setLocation($marketData[$item['fleamarket_id']]['location'])
                ->setUrl($marketData[$item['fleamarket_id']]['url']);

            $mappedMarkets[] = $fleaMarket;
        }

        return $mappedMarkets;
    }

    private function _extractFleaMarketIds(array $date)
    {
        $ids = array();

        foreach ($date as $item) {
            $ids[] = $item['fleamarket_id'];
        }

        return array_unique($ids);
    }
}
