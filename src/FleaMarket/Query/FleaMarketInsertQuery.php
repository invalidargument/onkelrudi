<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;

class FleaMarketInsertQuery extends AbstractInsertQuery
{
    private $_name;
    private $_organizerId;

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function setOrganizerId($id)
    {
        $this->_organizerId = $id;
        return $this;
    }

    public function runQuery()
    {
        $insertStatement = $this->pdo
            ->insert(
                array('name', 'organizer_id')
            )
            ->into('fleamarkets')
            ->values(
                array($this->_name, $this->_organizerId)
            );

        return $insertStatement->execute();
    }
}
