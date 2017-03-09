<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\User\User;
use Slim\App;

class UserPasswordChangeActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderTestActionChangesPassword
     */
    public function testActionChangesPassword($oldPassword, $newPassword, $newPassword2, $serviceResponse, $expectedResult)
    {
        $user = new User('test@example.com', $oldPassword);
        $builderFactory = new BuilderFactory();

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn(new User('test@example.com'));
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);
        
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service
            ->shouldReceive('changePassword')
                ->once()
                ->with(\Hamcrest\Matchers::equalTo($user), $newPassword)
                ->andReturn($serviceResponse)
            ->shouldReceive('getAuthenticationService')->andReturn($authenticationService);

        $parsedJson = [
            'password_old' => $oldPassword,
            'password_new' => $newPassword,
            'password_new_repeated' => $newPassword2
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

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode($expectedResult);

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    public function dataProviderTestActionChangesPassword()
    {
        return array(
            array('oldPassword', 'newPassword', 'newPassword', true, array('data' => 1)),
            array('oldPassword', 'newPassword', 'newPassword', false, array('error' => 'Error while persisting new password')),
            array('oldPassword', 'newPass', 'newPasss', true, array('error' => 'New passwords do not match')),
            array('oldPassword', 'newPass', 'newPass', true, array('error' => 'Passwords must have a minimum length of 8 chracters')),
        );
    }
}
