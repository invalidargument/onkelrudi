<?php

namespace RudiBieller\OnkelRudi\User;

class OptInTokenTestUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new OptInTokenTestUpdateQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    protected function tearDown()
    {
        parent::tearDown();
        //\Mockery::close();
    }

    public function testQueryUpdatesUserWithGivenIdentifier()
    {
        $readStatement = \Mockery::mock('\PDOStatement');
        $readStatement->shouldReceive('fetch')->once()->andReturn(array('email' => 'info@onkel-rudi.de'));

        // update users
        $this->_pdo->shouldReceive('update->table->where')->andReturn($this->_pdo);
        $this->_pdo->shouldReceive('execute')->once()->andReturn(1);

        $this->_sut->setIdentifier('info@onkel-rudi.de');
        $result = $this->_sut->run();

        $this->assertSame(1, $result);
    }
}
