<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetails;

class FleaMarketDetailsReadQuery extends AbstractQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetails
     */
    private $_details;
    private $_detailsId;

    public function setDetailsId($id)
    {
        $this->_detailsId = $id;
        return $this;
    }

    protected function runQuery()
    {
        $selectStatement = $this->pdo
            ->select()
            ->from('fleamarkets_details')
            ->where('id', '=', $this->_detailsId);

        /**
         * @var \Slim\PDO\Statement
         */
        $statement = $selectStatement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    protected function mapResult($result)
    {
        $this->_details = new FleaMarketDetails();

        if ($result === false) {
            return $this->_details;
        }

        $this->_details
            ->setId($result['id'])
            ->setFleaMarketId($result['fleamarket_id'])
            ->setDescription($result['description'])
            ->setStart($result['start'])
            ->setEnd($result['end'])
            ->setStreet($result['street'])
            ->setStreetNo($result['streetno'])
            ->setCity($result['city'])
            ->setZipCode($result['zipcode'])
            ->setLocation($result['location'])
            ->setUrl($result['url']);

        return $this->_details;
    }
}
