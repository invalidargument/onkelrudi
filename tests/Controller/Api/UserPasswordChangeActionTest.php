<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\User\User;
use Slim\App;

class UserPasswordChangeActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionCHangesPassword()
    {
        $user = new User('test@example.com', 'oldPwd');
        $builderFactory = new BuilderFactory();

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn(new User('test@example.com'));
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);
        
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service
            ->shouldReceive('changePassword')
                ->once()
                ->with(\Hamcrest\Matchers::equalTo($user), 'newPwd')
                ->andReturn(true)
            ->shouldReceive('getAuthenticationService')->andReturn($authenticationService);

        $parsedJson = [
            'password_old' => 'oldPwd',
            'password_new' => 'newPwd',
            'password_new_repeated' => 'newPwd'
        ];

        $app = new App();
        $container = $app->getContainer();
        $container['config'] = new Config();
        $request = Factory::createTestRequest();
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = Factory::createStandardResponse();

        $action = new UserPasswordChangeAction();
        $action->setApp($app)
            ->setUserService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array('id' => 'test@example.com'));
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
