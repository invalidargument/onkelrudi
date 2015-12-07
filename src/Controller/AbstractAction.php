<?php

namespace RudiBieller\OnkelRudi\Controller;

use Psr\Http\Message\ServerRequestInterface,
    Psr\Http\Message\ResponseInterface,
    RudiBieller\OnkelRudi\ServiceInterface,
    RudiBieller\OnkelRudi\BuilderFactoryInterface;

abstract class AbstractAction implements ActionInterface
{
    protected $app;
    protected $service;
    /**
     * @var BuilderFactoryInterface
     */
    protected $builderFactory;
    protected $request;
    protected $response;
    protected $args;

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

        return $this->app->getContainer()->get('response')->withHeader(
            'Content-Type',
            'application/json'
        )->write(json_encode(array('data' => $this->getData())));
    }

    abstract protected function getData();
}