<?php

namespace RudiBieller\OnkelRudi\Controller;

use Psr\Http\Message\ServerRequestInterface,
    Psr\Http\Message\ResponseInterface,
    RudiBieller\OnkelRudi\ServiceInterface;

abstract class AbstractAction implements ActionInterface
{
    protected $app;
    protected $service;

    public function setApp(\Slim\App $app)
    {
        $this->app = $app;
    }

    public function setService(ServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->app->response->withHeader(
            'Content-Type',
            'application/json'
        )->write(json_encode(array('data' => $this->getData())));
    }

    abstract protected function getData();
}