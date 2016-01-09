<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Cocur\Slugify\Slugify;
use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class FleaMarketReadQuery extends AbstractQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
     */
    private $_fleaMarket;
    private $_fleaMarketId;

    public function setFleaMarketId($id)
    {
        $this->_fleaMarketId = $id;
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

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    protected function mapResult($result)
    {
        if ($result === false) {
            return $this->_fleaMarket;
        }

        $this->_fleaMarket = new FleaMarket();

        $this->_fleaMarket
            ->setId($result['id'])
            ->setUuid($result['uuid'])
            ->setName($result['name'])
            ->setSlug((new Slugify())->slugify($result['name']))
            ->setDescription($result['description'])
            ->setStart($result['start'])
            ->setEnd($result['end'])
            ->setStreet($result['street'])
            ->setStreetNo($result['streetno'])
            ->setCity($result['city'])
            ->setZipCode($result['zipcode'])
            ->setLocation($result['location'])
            ->setUrl($result['url']);

        return $this->_fleaMarket;
    }
}
