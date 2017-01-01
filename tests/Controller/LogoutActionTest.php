<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\User\User;

class LogoutActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionLogsOutUser()
    {
        $user = new User('foo@example.com', 'foobarbaz');

        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');

        $session = \Mockery::mock('Zend\Authentication\Storage\StorageInterface');
        $session->shouldReceive('read')->once()->andReturn($user)
            ->shouldReceive('clear')->once();
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session)
            ->shouldReceive('clearIdentity')->once();

        $builderFactory = new BuilderFactory();

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService)
            ->shouldReceive('isLoggedIn')->andReturn(true);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $app = Factory::createSlimAppWithStandardTestContainer();
        $request = Factory::createTestRequest();
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $action = new LogoutAction();
        $action->setApp($app)
            ->setUserService($userService)
            ->setWordpressService($wordpressService)
            ->setBuilderFactory($builderFactory);

        $action($request, $response, array());
    }
}
