<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class Builder
{
    private $_properties = array();

    public function setId($id)
    {
        $this->_properties['id'] = $id;
        return $this;
    }

    public function setOrganizer(OrganizerInterface $organizer)
    {
        $this->_properties['organizer'] = $organizer;
        return $this;
    }

    public function setName($name)
    {
        $this->_properties['name'] = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->_properties['description'] = $description;
        return $this;
    }

    public function setStart($start)
    {
        $this->_properties['start'] = $start;
        return $this;
    }

    public function setEnd($end)
    {
        $this->_properties['end'] = $end;
        return $this;
    }

    public function setStreet($street)
    {
        $this->_properties['street'] = $street;
        return $this;
    }

    public function setStreetNo($streetNo)
    {
        $this->_properties['streetNo'] = $streetNo;
        return $this;
    }

    public function setCity($city)
    {
        $this->_properties['city'] = $city;
        return $this;
    }

    public function setZipCode($zipCode)
    {
        $this->_properties['zipCode'] = $zipCode;
        return $this;
    }

    public function setLocation($location)
    {
        $this->_properties['location'] = $location;
        return $this;
    }

    public function setUrl($url)
    {
        $this->_properties['url'] = $url;
        return $this;
    }

    public function build()
    {
        $market = new FleaMarket();

        foreach ($this->_properties as $name => $value) {
            if (array_key_exists($name, $this->_properties) && !is_null($this->_properties[$name])) {
                $method = 'set' . ucfirst($name);
                $market->$method($value);
            }
        }

        return $market;
    }
}
