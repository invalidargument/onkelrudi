<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use Zend\Authentication\Storage\Session;

class LoginActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsRequestedMarket()
    {
        $app = Factory::createSlimAppWithStandardTestContainer();
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = Factory::createTestRequest();
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

        $action = new LoginAction();
        $action->setApp($app);
        $action->setWordpressService($wordpressService)
            ->setUserService($userService);

        $return = $action($request, $response, array('login_email' => 'foo@example.com', 'nonsense'));
        $actual = (string)$return->getBody();
        $expected = 'String representation of the Body object';

        $this->assertContains($expected, $actual);

        $this->assertAttributeEquals(
            ['loggedIn' => true, 'profileurl' => '/foo/', 'createfleamarketurl' => '/foo/', 'changepasswordurl' => '/foo/', 'logouturl' => '/foo/'],
            'templateVariables',
            $action
        );
    }
}
