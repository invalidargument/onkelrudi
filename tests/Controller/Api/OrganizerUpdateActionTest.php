<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\User\User;
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
            'url' => 'foo.com',
            'acceptDataProcessing' => true
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

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn(new User());
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService);

        $app = new App();
        $container = $app->getContainer();
        $container['config'] = new Config();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new OrganizerUpdateAction();
        $action->setApp($app)
            ->setUserService($userService)
            ->setOrganizerService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array('id' => 123));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    public function testActionDoesNotAllowMissingDsgvoAcceptance()
    {
        $this->markTestIncomplete('TODO DSGVO');
    }
}
