<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;

class OrganizerActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsMarket()
    {
        $organizer = new Organizer();
        $organizer->setId(23)->setName('Max Power');

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getOrganizer')->once()->with(42)->andReturn($organizer);

        $action = new OrganizerAction();
        $action->setApp($app);
        $action->setService($service);

        $return = $action($request, $response, array('id' => 42));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => $organizer));

        $this->assertSame(200, $return->getStatusCode());
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    public function testActionReturns404WhenNoMarketWasFound()
    {
        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response
            ->shouldReceive('withStatus')
            ->once()
            ->with(FleaMarketAction::DEFAULT_ERROR_RESPONSE_HTTP_STATUS_CODE, FleaMarketAction::DEFAULT_ERROR_RESPONSE_MESSAGE)
            ->andReturn($response);

        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getOrganizer')->andReturn(null);

        $action = new OrganizerAction();
        $action->setApp($app);
        $action->setService($service);

        $return = $action($request, $response, array('id' => 42));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('error' => FleaMarketAction::DEFAULT_ERROR_RESPONSE_MESSAGE));

        $this->assertSame(FleaMarketAction::DEFAULT_ERROR_RESPONSE_HTTP_STATUS_CODE, $return->getStatusCode());
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
