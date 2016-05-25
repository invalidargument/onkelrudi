<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

class UserLogoutActionTest
{
    public function testActionLogsOutUser()
    {
        $user = new User('foo@example.com', 'foobarbaz');

        $session = \Mockery::mock('Zend\Authentication\Storage\StorageInterface');
        $session->shouldReceive('clear')->once();
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session)
            ->shouldReceive('clearIdentity')->once();

        $builderFactory = new BuilderFactory();
        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $service->shouldReceive('getAuthenticationService')->once()->with(\Hamcrest\Matchers::equalTo($user))->andReturn($authenticationService);

        $app = new App();
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new UserLogoutAction();
        $action->setApp($app)
            ->setUserService($service)
            ->setBuilderFactory($builderFactory);

        $return = $action($request, $response, array());

        $this->assertTrue($return);
    }
}
