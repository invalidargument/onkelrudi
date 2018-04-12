<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use Slim\App;

class UserCreateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderTestActionCreatesNewUser
     */
    public function testActionCreatesNewUser($asOrganizer, $expectedUserCreateCall)
    {
        $parsedJson = [
            'email' => 'foo@example.com',
            'password' => 'foobarbaz',
            'password_repeat' => 'foobarbaz',
            'register_as_organizer' => $asOrganizer
        ];

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service->shouldReceive($expectedUserCreateCall)->once()->with('foo@example.com', \Hamcrest\Matchers::startsWith('$2y$10$'))->andReturn(1)
            ->shouldReceive('createOptInToken')->once()->with('foo@example.com')->andReturn(2);

        $notificationService = \Mockery::mock('RudiBieller\OnkelRudi\User\NotificationServiceInterface');
        $notificationService->shouldReceive('sendOptInNotification')->once()->with('foo@example.com', \Hamcrest\Matchers::containsString('Um Deine Registrierung abzuschließen und Deinen Account zu aktivieren, folge bitte diesem Link'));

        $app = Factory::createSlimAppWithStandardTestContainer();
        $container = $app->getContainer();

        $logger = \Mockery::mock('Monolog\Logger');
        $logger->shouldReceive('info');
        $container['Logger'] = $logger;

        $body = \Mockery::mock('Slim\Http\Body');
        $body->shouldReceive('write')
            ->once()
            ->with(\Hamcrest\Matchers::stringContainsInOrder(
                'um Deine Anmeldung bei Onkel Rudi abzuschließen, folge bitte diesem Link',
                'http://www.onkel-rudi.de/opt-in/token-2'
            ));
        $request = Factory::createTestRequest();
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

    public function dataProviderTestActionCreatesNewUser()
    {
        return array(
            array(true, 'createOrganizerUser'),
            array(false, 'createUser')
        );
    }

    /**
     * @dataProvider dataProviderTestActionChecksForPasswordRequirements
     */
    public function testActionChecksForPasswordRequirements($email, $password1, $password2, $responseMessage)
    {
        $parsedJson = [
            'email' => $email,
            'password' => $password1,
            'password_repeat' => $password2
        ];

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service->shouldReceive('createUser')->once()->with('foo@example.com', 'foobarbaz')->andReturn(1);

        $app = new App();
        $container = $app->getContainer();
        $container['config'] = new Config();
        $request = Factory::createTestRequest();
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
            array('foo@example.com', 'foo', 'foo', 'Passwords must have a minimum length of 8 chracters'),
            array('foo@example.com', 'foo', 'fooo', 'Passwords do not match'),
            array('invalid@email', 'aaaaaaaa', 'aaaaaaaa', 'No valid e-mail address')
        );
    }
}
