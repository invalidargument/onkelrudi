<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\ServiceInterface;

class Factory implements FactoryInterface
{
    private $_instances = array();
    private $_slimApp;
    private $_service;

    public function __construct(\Slim\App $app)
    {
        $this->_slimApp = $app;
    }

    public function setService(ServiceInterface $service)
    {
        $this->_service = $service;
    }

    public function createActionByName($name)
    {
        if (!class_exists($name)) {
            throw new \InvalidArgumentException('No matching action found for argument ' . $name);
        }

        if (isset($this->_instances[$name])) {
            return $this->_instances[$name];
        }

        $instance = new $name();
        $instance->setApp($this->_slimApp);
        $instance->setService($this->_service);
        $this->_instances[$name] = $instance;

        return $this->_instances[$name];
    }
}