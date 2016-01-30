<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarketServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FleaMarketService
     */
    private $_sut;
    private $_factory;

    protected function setUp()
    {
        $this->_sut = new FleaMarketService();
        $this->_factory = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\Factory');
        $this->_sut->setQueryFactory($this->_factory);
    }

    public function testServiceCreatesNewFleaMarket()
    {
        $organizer = new Organizer();
        $organizer->setId(42);

        $dates = array(new FleaMarketDate());

        $fleaMarket = new FleaMarket();
        $fleaMarket
            ->setUuid('uuid')
            ->setOrganizer($organizer)
            ->setName('Der erste Flohmarkt von Rudi')
            ->setDescription('Ein toller Flohmarkt')
            ->setCity('Cologne')
            ->setZipCode('5000')
            ->setStreet('Venloer')
            ->setStreetNo('20000')
            ->setDates($dates)
            ->setLocation('Daheim')
            ->setUrl('http://www.example.com/foo');

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketInsertQuery');
        $query
            ->shouldReceive('setFleaMarketService')->once()->with($this->_sut)->andReturn($query)
            ->shouldReceive('setUuid')->once()->with('uuid')->andReturn($query)
            ->shouldReceive('setOrganizerId')->once()->with('42')->andReturn($query)
            ->shouldReceive('setName')->once()->with('Der erste Flohmarkt von Rudi')->andReturn($query)
            ->shouldReceive('setDescription')->once()->with('Ein toller Flohmarkt')->andReturn($query)
            ->shouldReceive('setDates')->once()->with($dates)->andReturn($query)
            ->shouldReceive('setStreet')->once()->with('Venloer')->andReturn($query)
            ->shouldReceive('setStreetNo')->once()->with('20000')->andReturn($query)
            ->shouldReceive('setZipCode')->once()->with('5000')->andReturn($query)
            ->shouldReceive('setCity')->once()->with('Cologne')->andReturn($query)
            ->shouldReceive('setLocation')->once()->with('Daheim')->andReturn($query)
            ->shouldReceive('setUrl')->once()->with('http://www.example.com/foo')->andReturn($query)
            ->shouldReceive('run')->once()->andReturn('123');
        $this->_factory->shouldReceive('createFleaMarketInsertQuery')
            ->once()
            ->andReturn($query);

        $this->_sut->createFleaMarket($fleaMarket, $organizer);
    }

    public function testDeleteFleaMarketsDeletesSelectedFleaMarket()
    {
        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(23);

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDeleteQuery');
        $query->shouldReceive('setFleaMarket')->once()->with($fleaMarket)->andReturn($query)
            ->shouldReceive('run');

        $this->_factory->shouldReceive('createFleaMarketDeleteQuery')
            ->once()
            ->andReturn($query);

        $this->_sut->deleteFleaMarket($fleaMarket);
    }

    public function testGetAllReturnsListWithAllMarkets()
    {
        $markets = array();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadListQuery');
        $query
            ->shouldReceive('setFleaMarketService')->andReturn($query)
            ->shouldReceive('run')->once()->andReturn($markets);

        $this->_factory->shouldReceive('createFleaMarketReadListQuery')->once()->andReturn($query);

        $this->_sut->getAllFleaMarkets();
    }

    public function testGetFleaMarketsReturnsListWithMarketsByLimitAndOffset()
    {
        $markets = array();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadListQuery');
        $query
            ->shouldReceive('setLimit')->once()->with(42)->andReturn($query)
            ->shouldReceive('setOffset')->once()->with(23)->andReturn($query)
            ->shouldReceive('setFleaMarketService')->andReturn($query)
            ->shouldReceive('run')->once()->andReturn($markets);

        $this->_factory->shouldReceive('createFleaMarketReadListQuery')->once()->andReturn($query);

        $this->_sut->getFleaMarkets(42, 23);
    }

    public function testGetFleaMarketReturnsRequestedMarket()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadQuery');
        $query
            ->shouldReceive('setFleaMarketId')->once()->with(2)->andReturn($query)
            ->shouldReceive('setFleaMarketService')->once()->andReturn($query)
            ->shouldReceive('run')->once()->andReturn(new FleaMarket());

        $this->_factory->shouldReceive('createFleaMarketReadQuery')->once()->andReturn($query);

        $this->_sut->getFleaMarket(2);
    }

    public function testUpdateFleaMarket()
    {
        $this->_factory = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\Factory');
        $this->_sut->setQueryFactory($this->_factory);

        $fleaMarket = new FleaMarket();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketUpdateQuery');
        $query->shouldReceive('setFleaMarket')->once()->with($fleaMarket)->andReturn($query)
            ->shouldReceive('run')->once()->andReturn(1);
        $this->_factory->shouldReceive('createFleaMarketUpdateQuery')->once()->andReturn($query);

        $this->_sut->updateFleaMarket($fleaMarket);
    }

    public function testCreateDates()
    {
        $this->markTestIncomplete('lazy!');
    }

    public function testGetDatesByFleaMarket()
    {
        $this->markTestIncomplete('lazy!');
    }
}
