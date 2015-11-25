<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketInterface;

// TODO: AbstractExecuteQuery STATT AbstractInsertQuery!!

class FleaMarketDeleteQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
     */
    private $_fleaMarket;
    private $_fleaMarketId;

    public function setFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $this->_fleaMarket = $fleaMarket;
        return $this;
    }

    public function setFleaMarketId($id)
    {
        $this->_fleaMarketId = $id;
        return $this;
    }

    protected function runQuery()
    {
        $id = $this->_fleaMarketId ? $this->_fleaMarketId : $this->_fleaMarket->getId();

        $deleteStatement = $this->pdo
            ->delete()
            ->from('fleamarkets')
            ->where('id', '=', $id);

        return $deleteStatement->execute();
    }
}
