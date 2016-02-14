<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;
use Slim\Http\Body;

class FleaMarketDetailActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsRequestedMarket()
    {
        $organizer = new Organizer();
        $organizer->setId(2000);
        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(23)->setName('Rudis Market')
            ->setOrganizer($organizer);

        $app = new App();
        $container = $app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(
                dirname(__FILE__).'/../../public/templates',
                [
                    //'cache' => 'templates/cache'
                    'cache' => false
                ]
            );

            $view->addExtension(new \Slim\Views\TwigExtension(
                $c['router'],
                $c['request']->getUri()
            ));

            return $view;
        };
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getFleaMarket')->once()->with(42)->andReturn($fleaMarket);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $organizerService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');
        $organizerService->shouldReceive('getOrganizer')->once()->with(2000)->andReturn(new Organizer());

        $action = new FleaMarketDetailAction();
        $action->setApp($app);
        $action->setService($service);
        $action->setOrganizerService($organizerService);
        $action->setWordpressService($wordpressService);

        $return = $action($request, $response, array('id' => 42));
        $actual = (string)$return->getBody();
        $expected = 'String representation of the Body object';

        $this->assertContains($expected, $actual);
    }
}
