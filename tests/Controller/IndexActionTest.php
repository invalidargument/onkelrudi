<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use Slim\App;
use Slim\Http\Uri;
use Zend\Authentication\Storage\Session;

class IndexActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionSetsTemplateVariables()
    {
        $router = \Mockery::mock('Slim\Interfaces\RouterInterface');
        $router->shouldReceive('pathFor')->once()->andReturn('/foo/');

        $uri = new Uri('http', 'onkel-rudi.de');

        $app = new App();
        $container = $app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(
                dirname(__FILE__).'/../../public/templates',
                [
                    'cache' => false
                ]
            );

            $view->addExtension(new \Slim\Views\TwigExtension(
                $c['router'],
                $c['request']->getUri()
            ));

            return $view;
        };
        $container['router'] = $router;
        $container['config'] = new Config();
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($uri);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn(new Session());

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService)
            ->shouldReceive('isLoggedIn')->andReturn(false);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $fleamarketDates = [
            new FleaMarketDate('2018-08-08 10:00:00', '2018-12-12 14:00:00')
        ];
        $fleamarkets = [
            new FleaMarket()
        ];

        $fleamarketService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $fleamarketService->shouldReceive('getAllFleaMarketsByTimespan')->once()->andReturn($fleamarkets)
            ->shouldReceive('getAllUpcomingDates')->once()->andReturn($fleamarketDates);

        $action = new IndexAction();
        $action->setApp($app);
        $action->setService($fleamarketService)
            ->setWordpressService($wordpressService)
            ->setUserService($userService);

        $return = $action($request, $response, array('month' => '09-16', 'zip' => '50825'));
        $actual = (string)$return->getBody();
        $expected = 'String representation of the Body object';

        $this->assertContains($expected, $actual);

        $this->assertAttributeEquals(
            ['fleamarkets' => $fleamarkets, 'fleamarketsDetailsRoutes' => ['' => '/foo/'], 'wpCategories' => [], 'monthRange' => ['08-2018' => '08/2018'], 'zipAreaRange' => [], 'selectedMonth' => '09/16', 'selectedZipAreaRange' => '5', 'profileurl' => '/foo/', 'createfleamarketurl' => '/foo/', 'isLoggedIn' => false, 'isTest' => false],
            'templateVariables',
            $action
        );
    }
}
