<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Cocur\Slugify\Slugify;
use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketOrganizerReadQuery extends AbstractQuery
{
    private $_organizerId;

    public function setOrganizerId($id)
    {
        $this->_organizerId = $id;
        return $this;
    }

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_organizer')
            ->where('id', '=', $this->_organizerId);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    protected function mapResult($result)
    {
        $organizer = new Organizer();

        if ($result === false) {
            return $organizer;
        }

        $organizer
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

        return $organizer;
    }
}
