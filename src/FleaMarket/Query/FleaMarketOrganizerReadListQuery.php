<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketOrganizerReadListQuery extends AbstractQuery
{
    private $_organizers;
    private $_offset = 0;
    private $_limit = 20;

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

    public function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_organizer')
            ->limit($this->_limit)
            ->offset($this->_offset);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $this->mapResult($statement->fetchAll());
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
                ->setName($item['name'])
                ->setStreet($item['street'])
                ->setStreetNo($item['streetno'])
                ->setCity($item['city'])
                ->setZipCode($item['zipcode'])
                ->setPhone($item['phone'])
                ->setUrl($item['url']);

            $this->_organizers[] = $organizer;
        }

        return $this->_organizers;
    }
}
