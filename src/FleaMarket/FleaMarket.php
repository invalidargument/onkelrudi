<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarket implements FleaMarketInterface
{
    private $_id;
    private $_name;
    private $_organizerId;
    private $_organizer;
    private $_details;

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

    public function getOrganizer()
    {
        return $this->_organizer;
    }

    public function getDetails()
    {
        return $this->_details;
    }

    public function setOrganizer(OrganizerInterface $organizer)
    {
        $this->_organizer = $organizer;
        return $this;
    }

    public function setDetails(FleaMarketDetailsInterface $details)
    {
        $this->_details = $details;
        return $this;
    }
}
