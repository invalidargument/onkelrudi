<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface;
use RudiBieller\OnkelRudi\ServiceInterface;
use RudiBieller\OnkelRudi\User\UserServiceInterface;
use RudiBieller\OnkelRudi\Wordpress\ServiceInterface as WordpressServiceInterface;

class Factory implements FactoryInterface
{
    private $_instances = array();
    private $_slimApp;
    private $_service;
    private $_organizerService;
    private $_userService;
    private $_wpService;

    public function __construct(\Slim\App $app)
    {
        $this->_slimApp = $app;
    }

    public function setService(ServiceInterface $service)
    {
        $this->_service = $service;
    }

    public function setOrganizerService(OrganizerServiceInterface $service)
    {
        $this->_organizerService = $service;
    }

    public function setUserService(UserServiceInterface $service)
    {
        $this->_userService = $service;
    }

    public function setWordpressService(WordpressServiceInterface $service)
    {
        $this->_wpService = $service;
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
        $instance->setOrganizerService($this->_organizerService);
        $instance->setUserService($this->_userService);
        if ($instance instanceof HttpActionInterface) {
            $instance->setWordpressService($this->_wpService);
        }
        $this->_instances[$name] = $instance;

        return $this->_instances[$name];
    }
}
