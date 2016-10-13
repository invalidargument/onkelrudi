<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Cocur\Slugify\Slugify;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\Query\AbstractQuery;

class FleaMarketOrganizerByUserReadQuery extends AbstractQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
     */
    private $_organizer;
    private $_userId;

    public function setUserId($userId)
    {
        $this->_userId = $userId;
        return $this;
    }

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_organizer')
            ->join('fleamarkets_user_to_organizer', 'fleamarkets_organizer.id', '=', 'fleamarkets_user_to_organizer.organizer_id')
            ->where('fleamarkets_user_to_organizer.user_id', '=', $this->_userId);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    protected function mapResult($result)
    {
        $this->_organizer = new Organizer();

        if ($result === false) {
            return $this->_organizer;
        }

        $this->_organizer
            ->setId($result['id'])
            ->setUuid($result['uuid'])
            ->setName($result['name'])
            ->setSlug((new Slugify())->slugify($result['name']))
            ->setStreet($result['street'])
            ->setStreetNo($result['streetno'])
            ->setCity($result['city'])
            ->setZipCode($result['zipcode'])
            ->setPhone($result['phone'])
            ->setEmail($result['email'])
            ->setUrl($result['url']);

        return $this->_organizer;
    }
}
