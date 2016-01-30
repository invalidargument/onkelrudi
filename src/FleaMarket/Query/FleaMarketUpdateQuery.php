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
                    // TODO: organizer id
                    'name' => $this->_fleaMarket->getName(),
                    'description' => $this->_fleaMarket->getDescription(),
                    'street' => $this->_fleaMarket->getStreet(),
                    'streetno' => $this->_fleaMarket->getStreetNo(),
                    'city' => $this->_fleaMarket->getCity(),
                    'zipcode' => $this->_fleaMarket->getZipCode(),
                    'location' => $this->_fleaMarket->getLocation(),
                    'url' => $this->_fleaMarket->getUrl()
                )
            )
            ->table('fleamarkets')
            ->where('id', '=', $this->_fleaMarket->getId());

        return $updateStatement->execute();
    }
}
