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
        $service->shouldReceive('createUser')->once()->with('foo@example.com', \Hamcrest\Matchers::startsWith('$2y$10$'))->andReturn(1)
            ->shouldReceive('createOptInToken')->once()->with('foo@example.com')->andReturn(2);

        $notificationService = \Mockery::mock('RudiBieller\OnkelRudi\User\NotificationServiceInterface');
        $notificationService->shouldReceive('sendOptInNotification')->once()->with('foo@example.com', \Hamcrest\Matchers::containsString('Um Deine Registrierung abzuschließen und Deinen Account zu aktivieren, folge bitte diesem Link'));

        $app = new App();
        $container = $app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(
                dirname(__FILE__).'/../../public/templates',
                [
                    'cache' => false
                ]
            );

            $view->addExtension(new \Slim\Views\TwigExtension(
                $c['router'],
                $c['request']->getUri()
            ));

            return $view;
        };

        $body = \Mockery::mock('Slim\Http\Body');
        $body->shouldReceive('write')
            ->once()
            ->with(\Hamcrest\Matchers::stringContainsInOrder(
                'um Deine Anmeldung bei Onkel Rudi abzuschließen, folge bitte diesem Link',
                'http://www.onkel-rudi.de/opt-in/token-2'
            ));
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body);

        $action = new UserCreateAction();
        $action->setApp($app)
            ->setUserService($service)
            ->setBuilderFactory($builderFactory)
            ->setNotificationService($notificationService);

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
