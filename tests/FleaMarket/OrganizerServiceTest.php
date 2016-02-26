<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class OrganizerServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OrganizerService
     */
    private $_sut;
    private $_factory;

    protected function setUp()
    {
        $this->_sut = new OrganizerService();
        $this->_factory = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory');
        $this->_sut->setQueryFactory($this->_factory);
    }

    public function testServiceCreatesNewOrganizer()
    {
        $organizer = new Organizer();
        $organizer
            ->setUuid('uuid')
            ->setName('Rudi')
            ->setPhone('23')
            ->setEmail('foo@example.com')
            ->setCity('Köln')
            ->setZipCode('50000')
            ->setStreet('foo')
            ->setStreetNo('2000')
            ->setUrl('http://www.example.com');

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery');
        $query
            ->shouldReceive('setUuid')->once()->with('uuid')->andReturn($query)
            ->shouldReceive('setName')->once()->with('Rudi')->andReturn($query)
            ->shouldReceive('setStreet')->once()->with('foo')->andReturn($query)
            ->shouldReceive('setStreetNo')->once()->with('2000')->andReturn($query)
            ->shouldReceive('setZipCode')->once()->with('50000')->andReturn($query)
            ->shouldReceive('setCity')->once()->with('Köln')->andReturn($query)
            ->shouldReceive('setPhone')->once()->with('23')->andReturn($query)
            ->shouldReceive('setEmail')->once()->with('foo@example.com')->andReturn($query)
            ->shouldReceive('setUrl')->once()->with('http://www.example.com')->andReturn($query)
            ->shouldReceive('run')->once()->andReturn($query);

        $this->_factory->shouldReceive('createFleaMarketOrganizerInsertQuery')
            ->once()
            ->andReturn($query);
        $this->_sut->createOrganizer($organizer);
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

    public function testGetAllOrganizersReturnsListWithAllOrganizers()
    {
        $organizers = array();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadListQuery');
        $query->shouldReceive('run')->once()->andReturn($organizers);

        $this->_factory->shouldReceive('createFleaMarketOrganizerReadListQuery')->once()->andReturn($query);

        $this->_sut->getAllOrganizers();
    }
}
