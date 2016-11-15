<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\User\User;
use Slim\App;

class FleaMarketUpdateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionUpdatesPassedFleaMarket()
    {
        $parsedJson = [
            'id' => 1,
            'name' => 'foo',
            'city' => 'bar',
            'zipCode' => '12345',
            'description' => 'baz',
            'dates' => [],
            'location' => 'Cologne',
            'street' => 'Venloer',
            'streetNo' => 1,
            'url' => 'foo.com',
            'organizer' => '{"id":"192","name":"ONKEL RUDI","street":"Hauptstr.","streetNo":"42","zipCode":"50667","city":"Köln","phone":"0123456","email":"test@onkel-rudi.de","url":"http://www.onkel-rudi.de"}'
//            'organizer' => [
//                'id' => 192,
//                'name' => 'Onkel Organizer',
//                'street' => 'Hauptstr.',
//                'streetNo' => '2000',
//                'zipCode' => '50667',
//                'city' => 'Köln',
//                'phone' => '0123456',
//                'email' => 'test@onkel-rudi.de',
//                'url' => 'http://www.onkel-rudi.de'
//            ]
        ];

        $organizer = new Organizer();
        $organizer->setId('192')
            ->setName('ONKEL RUDI')
            ->setStreet('Hauptstr.')
            ->setStreetNo('42')
            ->setZipCode('50667')
            ->setCity('Köln')
            ->setPhone('0123456')
            ->setEmail('test@onkel-rudi.de')
            ->setUrl('http://www.onkel-rudi.de');

        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(1)
            ->setName('foo')
            ->setCity('bar')
            ->setZipCode(12345)
            ->setDescription('baz')
            ->setLocation('Cologne')
            ->setDates([])
            ->setStreet('Venloer')
            ->setStreetNo(1)
            ->setUrl('foo.com')
            ->setOrganizer($organizer);

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('updateFleaMarket')->once()->with(\Hamcrest\Matchers::equalTo($fleaMarket))->andReturn(1);

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn(new User());
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService);

        $app = new App();
        $container = $app->getContainer();
        $container['config'] = new Config();
        $request = Factory::createTestRequest();
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new FleaMarketUpdateAction();
        $action->setApp($app)
            ->setService($service)
            ->setUserService($userService)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array('id' => 123));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
