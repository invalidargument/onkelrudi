<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use Slim\App;

class FleaMarketDeleteActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionCreatesNewFleaMarket()
    {
        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(1);

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('deleteFleaMarket')->once()->with(\Hamcrest\Matchers::equalTo($fleaMarket))->andReturn(1);

        $app = new App();
        $container = $app->getContainer();
        $container['config'] = new Config();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new FleaMarketDeleteAction();
        $action->setApp($app)
            ->setService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array('id' => 1));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
