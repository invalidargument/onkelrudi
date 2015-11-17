<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarket implements FleaMarketInterface
{
    private $_id;
    private $_name;
    private $_organizerId;

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setOrganizerId($organizerId)
    {
        $this->_organizerId = $organizerId;
        return $this;
    }

    public function getOrganizerId()
    {
        return $this->_organizerId;
    }
}
