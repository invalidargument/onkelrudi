<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\ImmutableInterface;

class User implements UserInterface, ImmutableInterface, \JsonSerializable
{
    private $_identifier;
    private $_password;
    private $_type;
    private $_optIn;

    public function __construct($identifier = null, $password = null, $type = UserInterface::TYPE_USER, $optIn = false)
    {
        $this->_identifier = $identifier;
        $this->_password = $password;

        if (!in_array($type, array(self::TYPE_USER, self::TYPE_ORGANIZER, self::TYPE_ADMIN))) {
            throw new \InvalidArgumentException('Invalid usertype given, allowed are ' . self::TYPE_USER . ' and ' . self::TYPE_ADMIN);
        }

        $this->_type = $type;
        $this->_optIn = $optIn;
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
     * @return string
     */
    public function getOptIn()
    {
        return $this->_optIn;
    }

    public function jsonSerialize()
    {
        return [
            'identifier' => $this->getIdentifier(),
            'type' => $this->getType()
        ];
    }
}
