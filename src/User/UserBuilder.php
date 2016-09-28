<?php

namespace RudiBieller\OnkelRudi\User;

class UserBuilder
{
    private $_type;
    private $_identifier;
    private $_password;
    private $_optIn = false;

    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    public function setOptIn($optIn)
    {
        $this->_optIn = $optIn;
        return $this;
    }

    public function build()
    {
        switch ($this->_type) {
            case UserInterface::TYPE_ORGANIZER:
                return new Organizer($this->_identifier, $this->_password, $this->_optIn);
            case UserInterface::TYPE_ADMIN:
                return new Admin($this->_identifier, $this->_password, $this->_optIn);
            default:
                return new User($this->_identifier, $this->_password, $this->_optIn);
        }
    }

    public function reset()
    {
        $this->_type = null;
        $this->_identifier = null;
        $this->_password = null;
        $this->_optIn = false;
    }
}
