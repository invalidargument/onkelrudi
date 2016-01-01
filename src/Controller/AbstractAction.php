<?php

namespace RudiBieller\OnkelRudi\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use RudiBieller\OnkelRudi\ServiceInterface;
use RudiBieller\OnkelRudi\BuilderFactoryInterface;

abstract class AbstractAction implements ActionInterface
{
    const DEFAULT_ERROR_RESPONSE_HTTP_STATUS_CODE = 404;
    const DEFAULT_ERROR_RESPONSE_MESSAGE = 'Resource not found';

    protected $app;
    protected $service;
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

    protected function writeErrorResponse()
    {
        return $this->app->getContainer()->get('response')
            ->withHeader(
                'Content-Type',
                'application/json'
            )
            ->withStatus($this->getResponseErrorStatusCode(), $this->getResponseErrorStatusMessage())
            ->write(json_encode(array('error' => $this->getResponseErrorStatusMessage())));
    }

    protected function writeSuccessResponse()
    {
        return $this->app->getContainer()->get('response')->withHeader(
            'Content-Type',
            'application/json'
        )->write(json_encode(array('data' => $this->result)));
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
