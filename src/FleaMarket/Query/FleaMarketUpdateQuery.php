<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface;
use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketInterface;

class FleaMarketUpdateQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
     */
    private $_fleaMarket;
    private $_fleaMarketService;

    /**
     * @param FleaMarketService $fleaMarketService
     * @return FleaMarketUpdateQuery
     */
    public function setFleaMarketService(FleaMarketServiceInterface $fleaMarketService)
    {
        $this->_fleaMarketService = $fleaMarketService;
        return $this;
    }

    public function setFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $this->_fleaMarket = $fleaMarket;
        return $this;
    }

    protected function runQuery()
    {
        $this->pdo->beginTransaction();

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

        $affected = $updateStatement->execute();

        $this->_fleaMarketService->deleteDates($this->_fleaMarket->getId());
        $this->_fleaMarketService->createDates($this->_fleaMarket->getId(), $this->_fleaMarket->getDates());

        $this->pdo->commit();

        return $affected;
    }
}
