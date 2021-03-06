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

    public function setOrganizer(OrganizerInterface $orgnizer)
    {
        $this->_organizer = $orgnizer;
        return $this;
    }

    protected function runQuery()
    {
        $date = new \DateTime(date('Y-m-d H:i:s'));

        $updateStatement = $this->pdo
            ->update(
                array(
                    'name' => $this->_organizer->getName(),
                    'street' => $this->_organizer->getStreet(),
                    'streetno' => $this->_organizer->getStreetNo(),
                    'city' => $this->_organizer->getCity(),
                    'zipcode' => $this->_organizer->getZipCode(),
                    'phone' => $this->_organizer->getPhone(),
                    'email' => $this->_organizer->getEmail(),
                    'url' => $this->_organizer->getUrl(),
                    'opt_in_dsgvo' => true,
                    'opt_in_dsgvo_ts' => $date->format('Y-m-d H:i:s')
                )
            )
            ->table('fleamarkets_organizer')
            ->where('id', '=', $this->_organizer->getId());

        return $updateStatement->execute();
    }
}
