<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;

class OrganizersActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsOrganizers()
    {
        $organizer = new Organizer();
        $organizer->setId(23)->setName('Rudis Market');
        $organizers = array($organizer);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $service->shouldReceive('getAllOrganizers')->once()->andReturn($organizers);

        $action = new OrganizersAction();
        $action->setApp($app);
        $action->setService($service);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => $organizers));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
