<?php

namespace RudiBieller\OnkelRudi\User;

use Slim\Container;

class UserReadQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $di = new Container([
            'UserBuilder' => function ($c) {
                return new UserBuilder();
            }
        ]);
        $this->_sut = new UserReadQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
        $this->_sut->setDiContainer($di);
    }

    public function testQuerySelectsAllParametersButNotThePassword()
    {
        $userData = ['type' => UserInterface::TYPE_ORGANIZER, 'opt_in' => true];

        $this->_sut->setIdentifier('foo@example.com');

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn($userData);

        $this->_pdo
            ->shouldReceive('select')
                ->with(['type', 'opt_in'])
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->with('fleamarkets_users')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('email', '=', 'foo@example.com')
            ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);

        $result = $this->_sut->run();

        $this->assertInstanceOf('RudiBieller\OnkelRudi\User\UserInterface', $result);
    }
}
