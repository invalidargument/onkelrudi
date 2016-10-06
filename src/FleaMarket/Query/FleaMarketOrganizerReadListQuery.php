<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Cocur\Slugify\Slugify;
use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketOrganizerReadListQuery extends AbstractQuery
{
    private $_organizers;
    private $_offset = 0;
    private $_limit = 50;

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

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_organizer')
            ->orderBy('name', 'ASC')
            ->limit($this->_limit, $this->_offset);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetchAll();
    }

    protected function mapResult($result)
    {
        $this->_organizers = array();

        if ($result === false) {
            return $this->_organizers;
        }

        foreach ($result as $item) {
            $organizer = new Organizer();
            $organizer
                ->setId($item['id'])
                ->setUuid($item['uuid'])
                ->setName($item['name'])
                ->setSlug((new Slugify())->slugify($item['name']))
                ->setStreet($item['street'])
                ->setStreetNo($item['streetno'])
                ->setCity($item['city'])
                ->setZipCode($item['zipcode'])
                ->setPhone($item['phone'])
                ->setEmail($item['email'])
                ->setUrl($item['url']);

            $this->_organizers[] = $organizer;
        }

        return $this->_organizers;
    }
}
