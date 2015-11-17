<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetailsInterface;

class FleaMarketDetailsDeleteQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetails
     */
    private $_fleaMarketDetails;
    private $_fleaMarketDetailsId;

    public function setFleaMarketDetails(FleaMarketDetailsInterface $fleaMarketDetails)
    {
        $this->_fleaMarketDetails = $fleaMarketDetails;
        return $this;
    }

    public function setFleaMarketDetailsId($id)
    {
        $this->_fleaMarketDetailsId = $id;
        return $this;
    }

    public function runQuery()
    {
        $id = $this->_fleaMarketDetailsId ? $this->_fleaMarketDetailsId : $this->_fleaMarketDetails->getId();

        $deleteStatement = $this->pdo
            ->delete()
            ->from('fleamarkets_details')
            ->where('id', '=', $id);

        return $deleteStatement->execute();
    }
}
