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

    public function testFactoryCreatesFleaMarketQuery()
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
                ->with(array('name', 'street', 'streetno', 'city', 'zipcode', 'phone', 'url'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets_organizer')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array('myname', 'mystreet', 'mystreetno', 'mycity', 'myzipcode', 'myphone', 'myurl'))
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn(1);
        $this->_sut->run();
    }
}
