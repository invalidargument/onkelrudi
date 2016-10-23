<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\User\User;
use RudiBieller\OnkelRudi\User\UserInterface;

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
        $user = new User('test@onkel-rudi.de', null, UserInterface::TYPE_ORGANIZER, true);
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
            ->setOrganizer($organizer)
            ->setUser($user);

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('createFleaMarket')->once()->with(\Hamcrest\Matchers::equalTo($fleaMarket))->andReturn(1);

        $authenticatedUser = new User('test@onkel-rudi.de', null, UserInterface::TYPE_ORGANIZER, true);
        $userService = Factory::createUserServiceWithAuthenticatedUserSession($authenticatedUser);

        $request = Factory::createTestRequest();
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = Factory::createStandardResponse();

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
