<?php

namespace RudiBieller\OnkelRudi\User;

class User implements UserInterface, \JsonSerializable
{
    private $_identifier;
    private $_password;
    private $_type;

    public function __construct($identifier = null, $password = null)
    {
        $this->_identifier = $identifier;
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * @param string $identifier
     * @return User
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param string $type
     * @return User
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        if (!in_array($type, array(self::TYPE_USER, self::TYPE_ADMIN))) {
            throw new \InvalidArgumentException('Invalid usertype given, allowed are ' . self::TYPE_USER . ' and ' . self::TYPE_ADMIN);
        }

        $this->_type = $type;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'identifier' => $this->getIdentifier(),
            'password' => $this->getPassword(),
            'type' => $this->getType()
        ];
    }
}
