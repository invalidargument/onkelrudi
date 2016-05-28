<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;

class FleaMarketCreateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionCreatesNewFleaMarket()
    {
        $config = \Mockery::mock('RudiBieller\OnkelRudi\Config\Config');
        $config->shouldReceive('getSystemConfiguration')->andReturn(array('environment' => 'dev'));

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

        $app = new App();
        $container = $app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(
                dirname(__FILE__).'/../../public/templates',
                ['cache' => false]
            );

            $view->addExtension(new \Slim\Views\TwigExtension(
                $c['router'],
                $c['request']->getUri()
            ));

            return $view;
        };
        $container['config'] = $config;

        $uri = \Mockery::mock('Slim\Http\Uri');
        $uri->shouldReceive('getQuery')->andReturn('/foo/?test=1');

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn(null);
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson)
            ->shouldReceive('getUri')->andReturn($uri);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

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
