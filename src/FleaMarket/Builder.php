<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\AbstractBuilder;

class Builder extends AbstractBuilder
{
    public function setId($id)
    {
        $this->properties['id'] = $id;
        return $this;
    }

    public function setOrganizer(OrganizerInterface $organizer)
    {
        $this->properties['organizer'] = $organizer;
        return $this;
    }

    public function setName($name)
    {
        $this->properties['name'] = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->properties['description'] = $description;
        return $this;
    }

    public function setStart($start)
    {
        $this->properties['start'] = $start;
        return $this;
    }

    public function setEnd($end)
    {
        $this->properties['end'] = $end;
        return $this;
    }

    public function setStreet($street)
    {
        $this->properties['street'] = $street;
        return $this;
    }

    public function setStreetNo($streetNo)
    {
        $this->properties['streetNo'] = $streetNo;
        return $this;
    }

    public function setCity($city)
    {
        $this->properties['city'] = $city;
        return $this;
    }

    public function setZipCode($zipCode)
    {
        $this->properties['zipCode'] = $zipCode;
        return $this;
    }

    public function setLocation($location)
    {
        $this->properties['location'] = $location;
        return $this;
    }

    public function setUrl($url)
    {
        $this->properties['url'] = $url;
        return $this;
    }

    public function build()
    {
        $market = new FleaMarket();

        foreach ($this->properties as $name => $value) {
            if (array_key_exists($name, $this->properties) && !is_null($this->properties[$name])) {
                $method = 'set' . ucfirst($name);
                $market->$method($value);
            }
        }

        return $market;
    }
}
