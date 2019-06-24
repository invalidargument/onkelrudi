<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;

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

        $app = Factory::createSlimAppWithStandardTestContainer();
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = Factory::createTestRequest();
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
                ['hasValidDate' => false, 'nextValidDateStart' => '2015-01-01 09:00:00', 'nextValidDateEnd' => '2015-01-01 12:30:00', 'profileurl' => '/foo/', 'createfleamarketurl' => '/foo/', 'changepasswordurl' => '/foo/', 'logouturl' => '/foo/', 'currentUrl' => '/foo/']
            ),
            array(
                [
                    new FleaMarketDate('2015-01-01 09:00:00', '2015-01-01 12:30:00'),
                    new FleaMarketDate('2021-01-01 09:00:00', '2021-01-01 12:30:00')
                ],
                ['hasValidDate' => true, 'nextValidDateStart' => '2021-01-01 09:00:00', 'nextValidDateEnd' => '2021-01-01 12:30:00', 'profileurl' => '/foo/', 'createfleamarketurl' => '/foo/', 'changepasswordurl' => '/foo/', 'logouturl' => '/foo/', 'currentUrl' => '/foo/']
            ),
            array(
                [
                    new FleaMarketDate('2028-01-01 09:00:00', '2028-01-01 12:30:00'),
                    new FleaMarketDate('2021-01-01 09:00:00', '2021-01-01 12:30:00')
                ],
                ['hasValidDate' => true, 'nextValidDateStart' => '2028-01-01 09:00:00', 'nextValidDateEnd' => '2028-01-01 12:30:00', 'profileurl' => '/foo/', 'createfleamarketurl' => '/foo/', 'changepasswordurl' => '/foo/', 'logouturl' => '/foo/', 'currentUrl' => '/foo/']
            )
        );
    }
}
