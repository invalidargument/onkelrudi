<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;
use Slim\Http\Body;

class FleaMarketDetailActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderTestActionReturnsRequestedMarket
     */
    public function testActionReturnsRequestedMarket(array $dates, $templateVariables)
    {
        $organizer = new Organizer();
        $organizer->setId(2000);
        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(23)->setName('Rudis Market')
            ->setOrganizer($organizer)
            ->setDates($dates);

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
        $container['config'] = new Config();
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getFleaMarket')->once()->with(42)->andReturn($fleaMarket);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserServiceInterface');
        $userService->shouldReceive('isLoggedIn')->andReturn(false);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $organizerService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');
        $organizerService->shouldReceive('getOrganizer')->once()->with(2000)->andReturn(new Organizer());

        $action = new FleaMarketDetailAction();
        $action->setApp($app);
        $action->setService($service);
        $action->setOrganizerService($organizerService);
        $action->setWordpressService($wordpressService);
        $action->setUserService($userService);

        $return = $action($request, $response, array('id' => 42));
        $actual = (string)$return->getBody();
        $expected = 'String representation of the Body object';

        $this->assertContains($expected, $actual);
        $this->assertAttributeEquals($templateVariables, 'templateVariables', $action);
    }

    public function dataProviderTestActionReturnsRequestedMarket()
    {
        return array(
            array(
                [
                    new FleaMarketDate('2015-01-01 09:00:00', '2015-01-01 12:30:00')
                ],
                ['hasValidDate' => false, 'nextValidDateStart' => '2015-01-01 09:00:00', 'nextValidDateEnd' => '2015-01-01 12:30:00']
            ),
            array(
                [
                    new FleaMarketDate('2015-01-01 09:00:00', '2015-01-01 12:30:00'),
                    new FleaMarketDate('2019-01-01 09:00:00', '2019-01-01 12:30:00')
                ],
                ['hasValidDate' => true, 'nextValidDateStart' => '2019-01-01 09:00:00', 'nextValidDateEnd' => '2019-01-01 12:30:00']
            ),
            array(
                [
                    new FleaMarketDate('2019-01-01 09:00:00', '2019-01-01 12:30:00'),
                    new FleaMarketDate('2021-01-01 09:00:00', '2021-01-01 12:30:00')
                ],
                ['hasValidDate' => true, 'nextValidDateStart' => '2019-01-01 09:00:00', 'nextValidDateEnd' => '2019-01-01 12:30:00']
            )
        );
    }
}
