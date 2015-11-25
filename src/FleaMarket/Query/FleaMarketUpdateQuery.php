<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketInterface;

class FleaMarketUpdateQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
     */
    private $_fleaMarket;

    public function setFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $this->_fleaMarket = $fleaMarket;
        return $this;
    }

    protected function runQuery()
    {
        $updateStatement = $this->pdo
            ->update(
                array(
                    'name' => $this->_fleaMarket->getName(),
                    'organizer_id' => $this->_fleaMarket->getOrganizerId()
                )
            )
            ->table('fleamarkets')
            ->where('id', '=', $this->_fleaMarket->getId());

        return $updateStatement->execute();
    }
}
