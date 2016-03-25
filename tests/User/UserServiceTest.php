<?php

namespace RudiBieller\OnkelRudi\User;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceCreatesNewUserWithMinimumUserCredentials()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\InsertQuery');
        $query->shouldReceive('setIdentifier')->with('foo')->andReturn($query)
            ->shouldReceive('setPassword')->with('bar')->andReturn($query)
            ->shouldReceive('run')->andReturn(1);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createUserInsertQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame(1, $service->createUser('foo', 'bar'));
    }

    public function testServiceLogsInUserByGivenCredentials()
    {
        $authAdapter = new DbAuthenticationAdapter();
        $authService = \Mockery::mock('Zend\Authentication\AuthenticationServiceInterface');
        $authService->shouldReceive('authenticate')->once()->andReturn(true);
        $authFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\AuthenticationFactory');
        $authFactory->shouldReceive('createAuthAdapter')->once()->with('foo', 'bar')->andReturn($authAdapter)
            ->shouldReceive('createAuthService')->once()->with($authAdapter, null)->andReturn($authService);

        $service = new UserService();
        $service->setAuthenticationFactory($authFactory);

        $this->assertSame(true, $service->login('foo', 'bar'));
    }
}
