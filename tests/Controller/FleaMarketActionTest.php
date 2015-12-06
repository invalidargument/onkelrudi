<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use Slim\App;

class FleaMarketActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsMarket()
    {
        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(23)->setName('Rudis Market');
        $market = $fleaMarket;

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getFleaMarket')->once()->with(42)->andReturn($market);

        $action = new FleaMarketAction();
        $action->setApp($app);
        $action->setService($service);

        $return = $action($request, $response, array('id' => 42));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => $market));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}