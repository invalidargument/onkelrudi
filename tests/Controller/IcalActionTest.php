<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\Ical\Service;

class IcalActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionSendsIcalWithAppropriateHeaders()
    {
        $fleamarket = new FleaMarket();
        $fleamarket->setDates([
            new FleaMarketDate('2016-10-23 12:00:13', '2016-10-23 16:10:17')
        ]);
        $app = Factory::createSlimAppWithStandardTestContainer();

        $action = new IcalAction();

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getFleaMarket')->once()->with('42')->andReturn($fleamarket);
        $userService = Factory::createUserServiceWithAuthenticatedUserSession();
        $userService->shouldReceive('isLoggedIn')->andReturn(false);

        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write');

        $action->setApp($app)
            ->setService($service)
            ->setUserService($userService)
            ->setBuilderFactory($builderFactory)
            ->setIcalService(new Service());

        $request = Factory::createTestRequest();
        $response = Factory::createStandardResponse();
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $return = $action($request, $response, array('id' => '42', 'date' => '23.10.2016'));
        $actual = (string)$return->getBody();
    }
}
