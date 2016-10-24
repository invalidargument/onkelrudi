<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface;
use RudiBieller\OnkelRudi\ServiceInterface;
use RudiBieller\OnkelRudi\User\NotificationServiceInterface;
use RudiBieller\OnkelRudi\User\UserServiceInterface;
use RudiBieller\OnkelRudi\Wordpress\ServiceInterface as WordpressServiceInterface;
use RudiBieller\OnkelRudi\Ical\ServiceInterface as IcalServiceInterface;

class Factory implements FactoryInterface
{
    private $_instances = array();
    private $_slimApp;
    private $_service;
    private $_organizerService;
    private $_userService;
    private $_notificationService;
    private $_wpService;
    private $_icalService;

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

    public function setNotificationService(NotificationServiceInterface $service)
    {
        $this->_notificationService = $service;
    }

    public function setWordpressService(WordpressServiceInterface $service)
    {
        $this->_wpService = $service;
    }

    public function setIcalService(IcalServiceInterface $service)
    {
        $this->_icalService = $service;
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
        $instance->setNotificationService($this->_notificationService);
        if ($instance instanceof HttpActionInterface) {
            $instance->setWordpressService($this->_wpService);
        }
        if ($instance instanceof IcalActionInterface) {
            $instance->setIcalService($this->_icalService);
        }
        $this->_instances[$name] = $instance;

        return $this->_instances[$name];
    }
}
