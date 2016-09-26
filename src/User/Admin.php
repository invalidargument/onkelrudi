<?php

namespace RudiBieller\OnkelRudi\User;

class Admin implements UserInterface, \JsonSerializable
{
    private $_identifier;
    private $_password;
    private $_hasOptIn;

    public function __construct($identifier = null, $password = null, $hasOptIn = false)
    {
        $this->_identifier = $identifier;
        $this->_password = $password;
        $this->_hasOptIn = $hasOptIn;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return boolean
     */
    public function hasOptIn()
    {
        return $this->_hasOptIn;
    }

    public function jsonSerialize()
    {
        return [
            'identifier' => $this->getIdentifier(),
            'password' => '',
            'hasOptIn' => (string) $this->hasOptIn()
        ];
    }
}
