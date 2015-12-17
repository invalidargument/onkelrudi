<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;

class OrganizerCreateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionCreatesNewOrganizer()
    {
        $parsedJson = [
            'name' => 'foo',
            'street' => 'Venloer',
            'streetNo' => 1,
            'zipCode' => '12345',
            'city' => 'bar',
            'phone' => '0221 2345',
            'url' => 'foo.com'
        ];
        $organizer = new Organizer();
        $organizer->setName('foo')
            ->setStreet('Venloer')
            ->setStreetNo(1)
            ->setZipCode(12345)
            ->setCity('bar')
            ->setPhone('0221 2345')
            ->setUrl('foo.com');

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('createOrganizer')->once()->with(\Hamcrest\Matchers::equalTo($organizer))->andReturn(1);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new OrganizerCreateAction();
        $action->setApp($app)
            ->setService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}