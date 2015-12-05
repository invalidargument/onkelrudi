<?php

namespace RudiBieller\OnkelRudi\Controller;

use Psr\Http\Message\ServerRequestInterface,
    Psr\Http\Message\ResponseInterface,
    RudiBieller\OnkelRudi\ServiceInterface;

class FleaMarketAction implements ActionInterface
{
    private $_app;
    private $_service;

    public function setApp(\Slim\App $app)
    {
        $this->_app = $app;
    }

    public function setService(ServiceInterface $service)
    {
        $this->_service = $service;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $fleaMarkets = $this->_service->getAllFleaMarkets();

        return $this->_app->response->withHeader(
            'Content-Type',
            'application/json'
        )->write(json_encode(array('fleamarkets' => $fleaMarkets)));
    }
}