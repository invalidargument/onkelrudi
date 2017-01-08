<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface;
use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketInterface;

class FleaMarketUpdateQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
     */
    private $_fleaMarket;
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface
     */
    private $_fleaMarketService;
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface
     */
    private $_organizerService;

    /**
     * @param \RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface $fleaMarketService
     */
    public function setFleaMarketService(FleaMarketServiceInterface $fleaMarketService)
    {
        $this->_fleaMarketService = $fleaMarketService;
    }

    /**
     * @param \RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface $organizerService
     */
    public function setOrganizerService(OrganizerServiceInterface $organizerService)
    {
        $this->_organizerService = $organizerService;
    }

    public function setFleaMarket(FleaMarketInterface $fleaMarket)
    {
        $this->_fleaMarket = $fleaMarket;
        return $this;
    }

    protected function runQuery()
    {
        $hasOrganizer = false;

        $updateData = array(
            'name' => $this->_fleaMarket->getName(),
            'description' => $this->_fleaMarket->getDescription(),
            'street' => $this->_fleaMarket->getStreet(),
            'streetno' => $this->_fleaMarket->getStreetNo(),
            'city' => $this->_fleaMarket->getCity(),
            'zipcode' => $this->_fleaMarket->getZipCode(),
            'location' => $this->_fleaMarket->getLocation(),
            'url' => $this->_fleaMarket->getUrl()
        );

        if (!is_null($this->_fleaMarket->getOrganizer()) && !is_null($this->_fleaMarket->getOrganizer()->getId())) {
            $updateData['organizer_id'] = $this->_fleaMarket->getOrganizer()->getId();
            $hasOrganizer = true;
        }

        $this->pdo->beginTransaction();

        $updateStatement = $this->pdo
            ->update(
                $updateData
            )
            ->table('fleamarkets')
            ->where('id', '=', $this->_fleaMarket->getId());

        $affected = $updateStatement->execute();

        $this->_fleaMarketService->deleteDates($this->_fleaMarket->getId());
        $this->_fleaMarketService->createDates($this->_fleaMarket->getId(), $this->_fleaMarket->getDates());

        if ($hasOrganizer && !$this->_isEmptyOrganizer()) {
            $this->_organizerService->updateOrganizer($this->_fleaMarket->getOrganizer());
        }

        $this->pdo->commit();

        return $affected;
    }

    private function _isEmptyOrganizer()
    {
        return $this->_fleaMarket->getOrganizer()->getName() == ''
            && $this->_fleaMarket->getOrganizer()->getStreet() == ''
            && $this->_fleaMarket->getOrganizer()->getStreetNo() == ''
            && $this->_fleaMarket->getOrganizer()->getZipCode() == ''
            && $this->_fleaMarket->getOrganizer()->getCity() == ''
            && $this->_fleaMarket->getOrganizer()->getPhone() == ''
            && $this->_fleaMarket->getOrganizer()->getEmail() == ''
            && $this->_fleaMarket->getOrganizer()->getUrl() == '';
    }
}
