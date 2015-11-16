<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerInterface;

class FleaMarketOrganizerUpdateQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
     */
    private $_organizer;

    public function setorganizer(OrganizerInterface $orgnizer)
    {
        $this->_organizer = $orgnizer;
        return $this;
    }

    public function runQuery()
    {
        $updateStatement = $this->pdo
            ->update(
                array(
                    'name' => $this->_organizer->getName(),
                    'street' => $this->_organizer->getStreet(),
                    'streetno' => $this->_organizer->getStreetNo(),
                    'city' => $this->_organizer->getCity(),
                    'zipcode' => $this->_organizer->getZipCode(),
                    'phone' => $this->_organizer->getPhone(),
                    'url' => $this->_organizer->getUrl()
                )
            )
            ->table('fleamarkets_organizer')
            ->where('id', '=', $this->_organizer->getId());

        return $updateStatement->execute();
    }
}
