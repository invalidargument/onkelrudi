<?php

namespace RudiBieller\OnkelRudi\User;

class InsertQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new InsertQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testInsertQueryStoresNewUserWithDefaultType()
    {
        $this->_sut->setIdentifier('foo@example.com')
            ->setPassword('bar');

        $this->_pdo
            ->shouldReceive('beginTransaction')->andReturn($this->_pdo)
            ->shouldReceive('commit')->andReturn($this->_pdo)
            ->shouldReceive('insert')
            ->once()
            ->with(array('email', 'password', 'type'))
            ->andReturn($this->_pdo)
            ->shouldReceive('into')
            ->once()
            ->with('fleamarkets_users')
            ->andReturn($this->_pdo)
            ->shouldReceive('values')
            ->once()
            ->with(array('foo@example.com', 'bar', 'user'))
            ->andReturn($this->_pdo)
            ->shouldReceive('execute')
            ->once()
            ->andReturn(1);
        $this->_sut->run();
    }

    /**
     * @dataProvider dataProviderTestInsertQueryStoresNewUserWithCustomType
     */
    public function testInsertQueryStoresNewUserWithCustomType($type, $expectedResultingType)
    {
        $this->_sut->setIdentifier('foo@example.com')
            ->setPassword('bar')
            ->setType($type);

        $this->_pdo
            ->shouldReceive('beginTransaction')->andReturn($this->_pdo)
            ->shouldReceive('commit')->andReturn($this->_pdo)
            ->shouldReceive('insert')
                ->once()
                ->with(array('email', 'password', 'type'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets_users')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array('foo@example.com', 'bar', $expectedResultingType))
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn(1);
        $this->_sut->run();
    }

    public function dataProviderTestInsertQueryStoresNewUserWithCustomType()
    {
        return array(
            array(null, 'user'),
            array('user', 'user'),
            array('organizer', 'organizer'),
            array('admin', 'admin'),
            array('master', 'user')
        );
    }
}
