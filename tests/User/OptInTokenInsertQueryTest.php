<?php

namespace RudiBieller\OnkelRudi\User;

class OptInTokenInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new OptInTokenInsertQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testInsertQueryStoresNewUser()
    {
        $this->_sut->setIdentifier('foo@example.com')
            ->setToken('bar');

        $this->_pdo
            ->shouldReceive('beginTransaction')->andReturn($this->_pdo)
            ->shouldReceive('commit')->andReturn($this->_pdo)
            ->shouldReceive('insert')
            ->once()
            ->with(array('email', 'token'))
            ->andReturn($this->_pdo)
            ->shouldReceive('into')
            ->once()
            ->with('fleamarkets_optins')
            ->andReturn($this->_pdo)
            ->shouldReceive('values')
            ->once()
            ->with(array('foo@example.com', 'bar'))
            ->andReturn($this->_pdo)
            ->shouldReceive('execute')
            ->once()
            ->andReturn(1);
        $this->_sut->run();
    }
}
