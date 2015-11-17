<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketInsertQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryUsesGivenValuesForRunningInsertStatement()
    {
        $this->_sut
            ->setName('myname')
            ->setOrganizerId('42');

        $this->_pdo
            ->shouldReceive('insert')
                ->once()
                ->with(array('name', 'organizer_id'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array('myname', '42'))
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once();
        $this->_sut->run();
    }
}
