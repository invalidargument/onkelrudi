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

        $this->assertSame(32, strlen($service->createOptInToken('foo')));
    }

    public function testCreateTestOptInPersistsNewToken()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\OptInTokenInsertQuery');
        $query->shouldReceive('setIdentifier')->with('foo')->andReturn($query)
            ->shouldReceive('setToken')->with('test123abc')->andReturn($query)
            ->shouldReceive('run')->andReturn(1);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createOptInTokenInsertQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame('test123abc', $service->createTestOptInToken('foo', 'test123abc'));
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

    public function testOptIn()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\OptInTokenUpdateQuery');
        $query->shouldReceive('setToken')->with('123abc456')->andReturn($query)
            ->shouldReceive('run')->andReturn(1);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createOptInTokenUpdateQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame(1, $service->optIn('123abc456'));
    }

    /**
     * @dataProvider dataProviderTestIsUserLoggedIn
     */
    public function testIsUserLoggedIn($storageContent, $expectedLoggedInStatus)
    {
        $storage = \Mockery::mock('Zend\Authentication\Storage\StorageInterface');
        $storage->shouldReceive('read')->andReturn($storageContent);

        $authService = \Mockery::mock('Zend\Authentication\AuthenticationServiceInterface');
        $authService->shouldReceive('getStorage')->andReturn($storage);

        $service = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService[getAuthenticationService]');
        $service->shouldReceive('getAuthenticationService')->once()->andReturn($authService);

        $this->assertSame($expectedLoggedInStatus, $service->isLoggedIn());
    }

    public function dataProviderTestIsUserLoggedIn()
    {
        return array(
            array(true, true),
            array(null, false)
        );
    }
}
