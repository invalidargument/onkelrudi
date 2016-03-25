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
        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\LoginQuery');
        $query->shouldReceive('setIdentifier')->with('foo')->andReturn($query)
            ->shouldReceive('setPassword')->with('bar')->andReturn($query)
            ->shouldReceive('run')->andReturn(password_hash('bar', PASSWORD_DEFAULT));

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createUserLoginQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame(true, $service->login('foo', 'bar'));
    }
}
