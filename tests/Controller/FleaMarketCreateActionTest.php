<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use Slim\App;

class FleaMarketCreateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionCreatesNewFleaMarket()
    {
        $parsedJson = [
            'name' => 'foo',
            'city' => 'bar',
            'zipCode' => '12345',
            'description' => 'baz',
            'start' => '2017-01-01 00:00:00',
            'end' => '2018-01-01 00:00:00',
            'location' => 'Cologne',
            'street' => 'Venloer',
            'streetNo' => 1,
            'url' => 'foo.com'
        ];
        $fleaMarket = new FleaMarket();
        $fleaMarket->setName('foo')
            ->setCity('bar')
            ->setZipCode(12345)
            ->setDescription('baz')
            ->setStart('2017-01-01 00:00:00')
            ->setEnd('2018-01-01 00:00:00')
            ->setLocation('Cologne')
            ->setStreet('Venloer')
            ->setStreetNo(1)
            ->setUrl('foo.com');

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('createFleaMarket')->once()->with(\Hamcrest\Matchers::equalTo($fleaMarket))->andReturn(1);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new FleaMarketCreateAction();
        $action->setApp($app)
            ->setService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}