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
}
