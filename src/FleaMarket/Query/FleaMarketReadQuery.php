<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

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
        $this->_fleaMarket = new FleaMarket();

        if ($result === false) {
            return $this->_fleaMarket;
        }

        $this->_fleaMarket
            ->setId($result['id'])
            ->setName($result['name'])
            ->setOrganizerId($result['organizer_id']);

        return $this->_fleaMarket;
    }
}
