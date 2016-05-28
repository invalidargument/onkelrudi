<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;

class FleaMarketCreateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionCreatesNewFleaMarket()
    {
        $app = Factory::createSlimAppWithStandardTestContainer();

        $parsedJson = [
            'name' => 'foo',
            'city' => 'bar',
            'zipCode' => '12345',
            'description' => 'baz',
            'dates' => [],
            'location' => 'Cologne',
            'street' => 'Venloer',
            'streetNo' => 1,
            'url' => 'foo.com',
            'organizerId' => 42
        ];

        $organizer = new Organizer();
        $organizer->setId(42);
        $fleaMarket = new FleaMarket();
        $fleaMarket->setName('foo')
            ->setCity('bar')
            ->setZipCode(12345)
            ->setDescription('baz')
            ->setDates([])
            ->setLocation('Cologne')
            ->setStreet('Venloer')
            ->setStreetNo(1)
            ->setUrl('foo.com')
            ->setOrganizer($organizer);

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('createFleaMarket')->once()->with(\Hamcrest\Matchers::equalTo($fleaMarket))->andReturn(1);

        $userService = Factory::createUserServiceWithAuthenticatedUserSession();

        $request = Factory::createTestRequest($parsedJson);
        $response = Factory::createStandardResponse();;

        $action = new FleaMarketCreateAction();
        $action->setApp($app)
            ->setService($service)
            ->setUserService($userService)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
