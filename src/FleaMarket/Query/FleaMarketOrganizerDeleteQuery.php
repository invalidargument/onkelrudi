<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerInterface;

class FleaMarketOrganizerDeleteQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
     */
    private $_organizer;
    private $_organizerId;

    public function setOrganizer(OrganizerInterface $organizer)
    {
        $this->_organizer = $organizer;
        return $this;
    }

    public function setOrganizerId($id)
    {
        $this->_organizerId = $id;
        return $this;
    }

    public function runQuery()
    {
        $id = $this->_organizerId ? $this->_organizerId : $this->_organizer->getId();

        $deleteStatement = $this->pdo
            ->delete()
            ->from('fleamarkets_organizer')
            ->where('id', '=', $id);

        return $deleteStatement->execute();
    }
}
