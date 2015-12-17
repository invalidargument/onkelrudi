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

    public function testServiceCreatesNewOrganizer()
    {
        $organizer = new Organizer();
        $organizer->setName('Rudi')
            ->setPhone('23')
            ->setCity('Köln')
            ->setZipCode('50000')
            ->setStreet('foo')
            ->setStreetNo('2000')
            ->setUrl('http://www.example.com');

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery');
        $query->shouldReceive('setName')->once()->with('Rudi')->andReturn($query)
            ->shouldReceive('setStreet')->once()->with('foo')->andReturn($query)
            ->shouldReceive('setStreetNo')->once()->with('2000')->andReturn($query)
            ->shouldReceive('setZipCode')->once()->with('50000')->andReturn($query)
            ->shouldReceive('setCity')->once()->with('Köln')->andReturn($query)
            ->shouldReceive('setPhone')->once()->with('23')->andReturn($query)
            ->shouldReceive('setUrl')->once()->with('http://www.example.com')->andReturn($query)
            ->shouldReceive('run')->once()->andReturn($query);

        $this->_factory->shouldReceive('createFleaMarketOrganizerInsertQuery')
            ->once()
            ->andReturn($query);
        $this->_sut->createOrganizer($organizer);
    }

    public function testServiceCreatesNewFleaMarket()
    {
        $organizer = new Organizer();
        $organizer->setId(42);

        $fleaMarket = new FleaMarket();
        $fleaMarket
            ->setOrganizer($organizer)
            ->setName('Der erste Flohmarkt von Rudi')
            ->setDescription('Ein toller Flohmarkt')
            ->setCity('Cologne')
            ->setZipCode('5000')
            ->setStreet('Venloer')
            ->setStreetNo('20000')
            ->setStart('2015-12-12 00:00:12')
            ->setEnd('2015-12-12 00:00:33')
            ->setLocation('Daheim')
            ->setUrl('http://www.example.com/foo');

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketInsertQuery');
        $query
            ->shouldReceive('setOrganizerId')->once()->with('42')->andReturn($query)
            ->shouldReceive('setName')->once()->with('Der erste Flohmarkt von Rudi')->andReturn($query)
            ->shouldReceive('setDescription')->once()->with('Ein toller Flohmarkt')->andReturn($query)
            ->shouldReceive('setStart')->once()->with('2015-12-12 00:00:12')->andReturn($query)
            ->shouldReceive('setEnd')->once()->with('2015-12-12 00:00:33')->andReturn($query)
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

    public function testDeleteOrganizerDeletesSelectedOrganizer()
    {
        $organizer = new Organizer();
        $organizer->setId(23);

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerDeleteQuery');
        $query->shouldReceive('setOrganizer')->once()->with($organizer)->andReturn($query)
            ->shouldReceive('run');

        $this->_factory->shouldReceive('createFleaMarketOrganizerDeleteQuery')
            ->once()
            ->andReturn($query);

        $this->_sut->deleteOrganizer($organizer);
    }

    public function testGetAllReturnsListWithAllMarkets()
    {
        $markets = array();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadListQuery');
        $query->shouldReceive('run')->once()->andReturn($markets);

        $this->_factory->shouldReceive('createFleaMarketReadListQuery')->once()->andReturn($query);

        $this->_sut->getAllFleaMarkets();
    }

    public function testGetFleaMarketReturnsRequestedMarket()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadQuery');
        $query->shouldReceive('setFleaMarketId')->once()->with(2)->andReturn($query)
            ->shouldReceive('run')->once()->andReturn(new FleaMarket());

        $this->_factory->shouldReceive('createFleaMarketReadQuery')->once()->andReturn($query);

        $this->_sut->getFleaMarket(2);
    }

    public function testGetOrganizerReturnsRequestedOrganizer()
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadQuery');
        $query->shouldReceive('setOrganizerId')->once()->with(23)->andReturn($query)
            ->shouldReceive('run')->once()->andReturn(new Organizer());

        $this->_factory->shouldReceive('createFleaMarketOrganizerReadQuery')->once()->andReturn($query);

        $this->_sut->getOrganizer(23);
    }

    public function testUpdateOrganizer()
    {
        $organizer = new Organizer();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerUpdateQuery');
        $query->shouldReceive('setOrganizer')->once()->with($organizer)->andReturn($query)
            ->shouldReceive('run')->once()->andReturn(1);

        $this->_factory->shouldReceive('createFleaMarketOrganizerUpdateQuery')->once()->andReturn($query);

        $this->_sut->updateOrganizer($organizer);
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

    public function testGetAllOrganizersReturnsListWithAllOrganizers()
    {
        $organizers = array();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadListQuery');
        $query->shouldReceive('run')->once()->andReturn($organizers);

        $this->_factory->shouldReceive('createFleaMarketOrganizerReadListQuery')->once()->andReturn($query);

        $this->_sut->getAllOrganizers();
    }
}
