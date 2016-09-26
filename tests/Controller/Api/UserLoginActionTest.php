<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\User\User;
use RudiBieller\OnkelRudi\User\UserInterface;
use Slim\App;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session;

class UserLoginActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionLogsInUser()
    {
        $parsedJson = [
            'email' => 'foo@example.com',
            'password' => 'foobarbaz'
        ];

        $user = new User('foo@example.com', 'foobarbaz');

        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('authenticate')->once()->andReturn(new Result(Result::SUCCESS, 'foo@example.com'))
            ->shouldReceive('getStorage')->once()->andReturn(new Session());

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service->shouldReceive('getAuthenticationService')->once()->with(\Hamcrest\Matchers::equalTo($user))->andReturn($authenticationService)
            ->shouldReceive('getUser')->once()->andReturn(new User('foo@example.com', null, UserInterface::TYPE_ORGANIZER, true));

        $app = new App();
        $container = $app->getContainer();
        $container['config'] = new Config();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new UserLoginAction();
        $action->setApp($app)
            ->setUserService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
