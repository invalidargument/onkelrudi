<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketOrganizerInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketOrganizerInsertQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryUsesGivenValuesForRunningInsertStatement()
    {
        $this->_sut
            ->setName('myname')
            ->setStreet('mystreet')
            ->setStreetNo('mystreetno')
            ->setCity('mycity')
            ->setZipCode('myzipcode')
            ->setPhone('myphone')
            ->setUrl('myurl');

        $this->_pdo
            ->shouldReceive('insert')
                ->once()
                ->with(array('uuid', 'name', 'street', 'streetno', 'city', 'zipcode', 'phone', 'url'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets_organizer')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array('a857f06c-0c36-569a-a664-dfd902701d4c', 'myname', 'mystreet', 'mystreetno', 'mycity', 'myzipcode', 'myphone', 'myurl'))
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once();
        $this->_sut->run();
    }
}
