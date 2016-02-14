<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

use RudiBieller\OnkelRudi\AbstractBuilder;

class OrganizerBuilder extends AbstractBuilder
{
    public function setId($id)
    {
        $this->properties['id'] = $id;
        return $this;
    }

    public function setUuid($uuid)
    {
        $this->properties['uuid'] = $uuid;
        return $this;
    }

    public function setName($name)
    {
        $this->properties['name'] = $name;
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

    public function setZipCode($zipCode)
    {
        $this->properties['zipCode'] = $zipCode;
        return $this;
    }

    public function setCity($city)
    {
        $this->properties['city'] = $city;
        return $this;
    }

    public function setPhone($phone)
    {
        $this->properties['phone'] = $phone;
        return $this;
    }

    public function setUrl($url)
    {
        $this->properties['url'] = $url;
        return $this;
    }

    public function build()
    {
        $organizer = new Organizer();

        foreach ($this->properties as $name => $value) {
            if (array_key_exists($name, $this->properties) && !is_null($this->properties[$name])) {
                $method = 'set' . ucfirst($name);
                $organizer->$method($value);
            }
        }

        return $organizer;
    }
}
