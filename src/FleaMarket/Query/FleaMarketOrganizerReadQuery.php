<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketOrganizerReadQuery extends AbstractQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
     */
    private $_organizer;
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
        $this->_organizer = new Organizer();

        if ($result === false) {
            return $this->_organizer;
        }

        $this->_organizer
            ->setId($result['id'])
            ->setName($result['name'])
            ->setStreet($result['street'])
            ->setStreetNo($result['streetno'])
            ->setCity($result['city'])
            ->setZipCode($result['zipcode'])
            ->setPhone($result['phone'])
            ->setUrl($result['url']);

        return $this->_organizer;
    }
}
