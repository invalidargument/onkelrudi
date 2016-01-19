<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;

class OrganizerUpdateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionUpdatesPassedOrganizer()
    {
        $parsedJson = [
            'id' => '1',
            'name' => 'foo',
            'street' => 'Venloer',
            'streetNo' => 1,
            'zipCode' => '12345',
            'city' => 'bar',
            'phone' => '0221 2345',
            'url' => 'foo.com'
        ];
        $organizer = new Organizer();
        $organizer->setId(1)
            ->setName('foo')
            ->setStreet('Venloer')
            ->setStreetNo(1)
            ->setZipCode(12345)
            ->setCity('bar')
            ->setPhone('0221 2345')
            ->setUrl('foo.com');

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerService');
        $service->shouldReceive('updateOrganizer')->once()->with(\Hamcrest\Matchers::equalTo($organizer))->andReturn(1);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new OrganizerUpdateAction();
        $action->setApp($app)
            ->setOrganizerService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array('id' => 123));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}