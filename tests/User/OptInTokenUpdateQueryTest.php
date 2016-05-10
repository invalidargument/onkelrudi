<?php

namespace RudiBieller\OnkelRudi\User;

class OptInTokenUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new OptInTokenUpdateQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    protected function tearDown()
    {
        parent::tearDown();
        //\Mockery::close();
    }

    public function testQueryUpdatesUserWhenTokenIsFound()
    {
        $readStatement = \Mockery::mock('\PDOStatement');
        $readStatement->shouldReceive('fetch')->once()->andReturn(array('email' => 'info@onkel-rudi.de'));

        // query email
        $this->_pdo->shouldReceive('select->from->where->where')->andReturn($this->_pdo);
        $this->_pdo->shouldReceive('execute')->once()->andReturn($readStatement);

        // update users
        $this->_pdo->shouldReceive('update->table->where')->andReturn($this->_pdo);
        $this->_pdo->shouldReceive('execute')->once()->andReturn(1);

        $result = $this->_sut->run();

        $this->assertSame(1, $result);
    }

    public function testQueryDoesNotUpdateUserWhenTokenIsNotFoundOrOutdatedFound()
    {
        $readStatement = \Mockery::mock('\PDOStatement');
        $readStatement->shouldReceive('fetch')->once()->andReturn(null);

        // query email
        $this->_pdo->shouldReceive('select->from->where->where')->andReturn($this->_pdo);
        $this->_pdo->shouldReceive('execute')->once()->andReturn($readStatement);

        // never update users
        $this->_pdo->shouldReceive('update->table->where')->never();

        $this->assertFalse($this->_sut->run());
    }
}
