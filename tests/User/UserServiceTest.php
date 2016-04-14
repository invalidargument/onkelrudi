<?php

namespace RudiBieller\OnkelRudi\User;

use Zend\Authentication\Storage\Session;

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

    public function testCreateOptInPersistsNewToken()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\OptInTokenInsertQuery');
        $query->shouldReceive('setIdentifier')->with('foo')->andReturn($query)
            ->shouldReceive('setToken')->with(\Hamcrest\Matchers::isNonEmptyString())->andReturn($query)
            ->shouldReceive('run')->andReturn(1);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createOptInTokenInsertQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame(1, $service->createOptInToken('foo'));
    }

    public function testServiceLogsInUserByGivenCredentials()
    {
        $user = new User('foo', 'bar');
        $sessionStorage = new Session();
        $authAdapter = new DbAuthenticationAdapter();
        $authService = \Mockery::mock('Zend\Authentication\AuthenticationServiceInterface');
        $authService->shouldReceive('authenticate')->once()->andReturn(true);
        $authFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\AuthenticationFactory');
        $authFactory->shouldReceive('createAuthAdapter')->once()->with($user)->andReturn($authAdapter)
            ->shouldReceive('createAuthService')->once()->with($authAdapter, $sessionStorage)->andReturn($authService)
            ->shouldReceive('createSessionStorage')->once()->andReturn($sessionStorage);

        $service = new UserService();
        $service->setAuthenticationFactory($authFactory);

        $this->assertSame(true, $service->login($user));
    }
}
