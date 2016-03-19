<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactory;
use Slim\App;

class UserCreateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionCreatesNewOrganizer()
    {
        $parsedJson = [
            'email' => 'foo@example.com',
            'password' => 'foobarbaz',
            'password_repeat' => 'foobarbaz'
        ];

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service->shouldReceive('createUser')->once()->with('foo@example.com', 'foobarbaz')->andReturn(1);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new UserCreateAction();
        $action->setApp($app)
            ->setUserService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    /**
     * @dataProvider dataProviderTestActionChecksForPasswordRequirements
     */
    public function testActionChecksForPasswordRequirements($password1, $password2, $responseMessage)
    {
        $parsedJson = [
            'email' => 'foo@example.com',
            'password' => $password1,
            'password_repeat' => $password2
        ];

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service->shouldReceive('createUser')->once()->with('foo@example.com', 'foobarbaz')->andReturn(1);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new UserCreateAction();
        $action->setApp($app)
            ->setUserService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('error' => $responseMessage));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    public function dataProviderTestActionChecksForPasswordRequirements()
    {
        return array(
            array('foo', 'foo', 'Passwords must have at least a length of 8 chracters'),
            array('foo', 'fooo', 'Passwords do not match')
        );
    }
}
