<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactory;
use Slim\App;
use Zend\Authentication\Result;

class UserLoginActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionLogsInUser()
    {
        $parsedJson = [
            'email' => 'foo@example.com',
            'password' => 'foobarbaz'
        ];

        $result = new Result(1, 'foo@example.com');

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service->shouldReceive('login')->once()->with('foo@example.com', 'foobarbaz')->andReturn($result);

        $app = new App();
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
