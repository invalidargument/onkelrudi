<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarketServiceTest extends \PHPUnit_Framework_TestCase
{
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

        $details = new FleaMarketDetails();
        $details->setDescription('Ein toller Flohmarkt')
            ->setCity('Cologne')
            ->setZipCode('5000')
            ->setStreet('Venloer')
            ->setStreetNo('20000')
            ->setStart('2015-12-12 00:00:12')
            ->setEnd('2015-12-12 00:00:33')
            ->setLocation('Daheim')
            ->setUrl('http://www.example.com/foo');

        $fleaMarket = new FleaMarket();
        $fleaMarket->setName('Der erste Flohmarkt von Rudi')
            ->setOrganizerId($organizer->getId());

        $detailsQuery = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsInsertQuery');
        $detailsQuery->shouldReceive('setFleaMarketId')->once()->with('123')->andReturn($detailsQuery)
            ->shouldReceive('setDescription')->once()->with('Ein toller Flohmarkt')->andReturn($detailsQuery)
            ->shouldReceive('setStart')->once()->with('2015-12-12 00:00:12')->andReturn($detailsQuery)
            ->shouldReceive('setEnd')->once()->with('2015-12-12 00:00:33')->andReturn($detailsQuery)
            ->shouldReceive('setStreet')->once()->with('Venloer')->andReturn($detailsQuery)
            ->shouldReceive('setStreetNo')->once()->with('20000')->andReturn($detailsQuery)
            ->shouldReceive('setZipCode')->once()->with('5000')->andReturn($detailsQuery)
            ->shouldReceive('setCity')->once()->with('Cologne')->andReturn($detailsQuery)
            ->shouldReceive('setLocation')->once()->with('Daheim')->andReturn($detailsQuery)
            ->shouldReceive('setUrl')->once()->with('http://www.example.com/foo')->andReturn($detailsQuery)
            ->shouldReceive('run')->once()->andReturn('1984');
        $this->_factory->shouldReceive('createFleaMarketDetailsInsertQuery')
            ->once()
            ->andReturn($detailsQuery);

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketInsertQuery');
        $query->shouldReceive('setName')->once()->with('Der erste Flohmarkt von Rudi')->andReturn($query)
            ->shouldReceive('setOrganizerId')->once()->with('42')->andReturn($query)
            ->shouldReceive('run')->once()->andReturn('123');
        $this->_factory->shouldReceive('createFleaMarketInsertQuery')
            ->once()
            ->andReturn($query);

        $this->_sut->createFleaMarket($fleaMarket, $details, $organizer);
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
}
