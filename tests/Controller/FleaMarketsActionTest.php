<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use Slim\App;

class FleaMarketsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsMarkets()
    {
        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(23)->setName('Rudis Market');
        $markets = array($fleaMarket);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getAllFleaMarkets')->once()->andReturn($markets);

        $action = new FleaMarketsAction();
        $action->setApp($app);
        $action->setService($service);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => $markets));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}