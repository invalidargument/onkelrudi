<?php

namespace RudiBieller\OnkelRudi\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RudiBieller\OnkelRudi\BuilderFactoryInterface;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface;
use RudiBieller\OnkelRudi\ServiceInterface;
use RudiBieller\OnkelRudi\User\NotificationServiceInterface;
use RudiBieller\OnkelRudi\User\UserService;
use RudiBieller\OnkelRudi\User\UserServiceInterface;

abstract class AbstractAction implements ActionInterface
{
    const DEFAULT_ERROR_RESPONSE_HTTP_STATUS_CODE = 404;
    const DEFAULT_ERROR_RESPONSE_MESSAGE = 'Resource not found';

    protected $app;
    protected $service;
    protected $organizerService;
    /**
     * @var \RudiBieller\OnkelRudi\User\UserService
     */
    protected $userService;
    /**
     * @var NotificationServiceInterface
     */
    protected $notificationService;
    /**
     * @var BuilderFactoryInterface
     */
    protected $builderFactory;
    protected $request;
    protected $response;
    protected $args;
    protected $result;
    protected $requestError;

    abstract protected function getData();

    abstract protected function writeErrorResponse();

    abstract protected function writeSuccessResponse();

    public function setApp(\Slim\App $app)
    {
        $this->app = $app;
        return $this;
    }

    public function setService(ServiceInterface $service)
    {
        $this->service = $service;
        return $this;
    }

    public function setOrganizerService(OrganizerServiceInterface $service)
    {
        $this->organizerService = $service;
        return $this;
    }

    public function setUserService(UserServiceInterface $service)
    {
        $this->userService = $service;
        return $this;
    }

    public function setNotificationService(NotificationServiceInterface $service)
    {
        $this->notificationService = $service;
        return $this;
    }

    public function setBuilderFactory(BuilderFactoryInterface $factory)
    {
        $this->builderFactory = $factory;
        return $this;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        $this->result = $this->getData();
        if ($this->isInvalidResult()) {
            return $this->writeErrorResponse();
        }

        return $this->writeSuccessResponse();
    }

    protected function isInvalidResult()
    {
        return is_null($this->result);
    }

    /**
     * @return int
     */
    protected function getResponseErrorStatusCode()
    {
        return self::DEFAULT_ERROR_RESPONSE_HTTP_STATUS_CODE;
    }

    /**
     * @return string
     */
    protected function getResponseErrorStatusMessage()
    {
        return self::DEFAULT_ERROR_RESPONSE_MESSAGE;
    }
}
