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
            ->shouldReceive('setType')->with(UserInterface::TYPE_USER)->andReturn($query)
            ->shouldReceive('run')->andReturn(1);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createUserInsertQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame(1, $service->createUser('foo', 'bar'));
    }

    public function testServiceCreatesNewAdminUser()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\InsertQuery');
        $query->shouldReceive('setIdentifier')->with('foo')->andReturn($query)
            ->shouldReceive('setPassword')->with('bar')->andReturn($query)
            ->shouldReceive('setType')->with(UserInterface::TYPE_ADMIN)->andReturn($query)
            ->shouldReceive('run')->andReturn(1);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createUserInsertQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame(1, $service->createAdminUser('foo', 'bar'));
    }

    public function testServiceCreatesNewOrganizerUser()
    {
        $db = \Mockery::mock('Slim\PDO\Database');
        $db->shouldReceive('beginTransaction')->once()->andReturn(true)
            ->shouldReceive('commit')->once()->andReturn(true);
        $diContainer = \Mockery::mock('Slim\Container');
        $diContainer->shouldReceive('get')->andReturn($db);

        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\InsertQuery');
        $query->shouldReceive('setIdentifier')->with('foo')->andReturn($query)
            ->shouldReceive('setPassword')->with('bar')->andReturn($query)
            ->shouldReceive('setType')->with(UserInterface::TYPE_ORGANIZER)->andReturn($query)
            ->shouldReceive('run')->andReturn(1000);

        $userToOrganizerQuery = \Mockery::mock('RudiBieller\OnkelRudi\User\UserToOrganizerInsertQuery');
        $userToOrganizerQuery->shouldReceive('setUserId')->once()->with('foo')->andReturn($userToOrganizerQuery)
            ->shouldReceive('setOrganizerId')->once()->with(23)->andReturn($userToOrganizerQuery)
            ->shouldReceive('run')->andReturn(0);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createUserInsertQuery')->once()->andReturn($query)
            ->shouldReceive('createUserToOrganizerInsertQuery')->once()->andReturn($userToOrganizerQuery);

        $organizerService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');
        $organizerService->shouldReceive('createOrganizer')->once()->with(\Hamcrest\Matchers::anInstanceOf('RudiBieller\OnkelRudi\FleaMarket\OrganizerInterface'))->andReturn(23);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);
        $service->setOrganizerService($organizerService);
        $service->setDiContainer($diContainer);

        $this->assertSame('foo', $service->createOrganizerUser('foo', 'bar'));
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

    public function testGetUserById()
    {
        $user = new User('foo@example.com', null, UserInterface::TYPE_ORGANIZER, true);

        $query = \Mockery::mock('RudiBieller\OnkelRudi\User\UserReadQuery');
        $query->shouldReceive('setIdentifier')->with('foo@example.com')->andReturn($query)
            ->shouldReceive('run')->andReturn($user);

        $queryFactory = \Mockery::mock('RudiBieller\OnkelRudi\User\QueryFactory');
        $queryFactory->shouldReceive('createUserReadQuery')->once()->andReturn($query);

        $service = new UserService();
        $service->setQueryFactory($queryFactory);

        $this->assertSame($user, $service->getUser('foo@example.com'));
    }
}
