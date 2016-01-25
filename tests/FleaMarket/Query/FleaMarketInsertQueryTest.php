<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;

class FleaMarketInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;
    private $_fleaMarketService;

    protected function setUp()
    {
        $this->_sut = new FleaMarketInsertQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);

        $this->_fleaMarketService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $this->_sut->setFleaMarketService($this->_fleaMarketService);
    }

    public function testQueryUsesGivenValuesForRunningInsertStatement()
    {
        $dates = array(new FleaMarketDate());
        $this->_fleaMarketService->shouldReceive('createDates')->once()->with(1, $dates);

        $this->_sut
            ->setOrganizerId('42')
            ->setName('myname')
            ->setDescription('foo')
            ->setStart('2015-12-12 00:00:00')
            ->setEnd('2015-12-13 00:00:00')
            ->setDates($dates)
            ->setStreet('bar')
            ->setStreetNo('42')
            ->setCity('baz')
            ->setZipCode('12345')
            ->setLocation('somewhere')
            ->setUrl('http://www.example.com');

        $this->_pdo
            ->shouldReceive('beginTransaction')->andReturn($this->_pdo)
            ->shouldReceive('commit')->andReturn($this->_pdo)
            ->shouldReceive('insert')
                ->once()
                ->with(array('uuid', 'organizer_id', 'name', 'description', 'start', 'end', 'street', 'streetno', 'city', 'zipcode', 'location', 'url'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
            ->with(array('4d7d0a79-9138-5e6c-9383-88179850520b', '42', 'myname', 'foo', '2015-12-12 00:00:00', '2015-12-13 00:00:00', 'bar', '42', 'baz', '12345', 'somewhere', 'http://www.example.com'))
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn(1);
        $this->_sut->run();
    }
}
