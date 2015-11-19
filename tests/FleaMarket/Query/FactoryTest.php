<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new Factory();
    }

    public function testFactoryCreatesFleaMarketDeleteQuery()
    {
        $query = $this->_sut->createFleaMarketDeleteQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDeleteQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketInsertQuery()
    {
        $query = $this->_sut->createFleaMarketInsertQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketInsertQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketReadListQuery()
    {
        $query = $this->_sut->createFleaMarketReadListQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadListQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketReadQuery()
    {
        $query = $this->_sut->createFleaMarketReadQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketUpdateQuery()
    {
        $query = $this->_sut->createFleaMarketUpdateQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketUpdateQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketOrganizerDeleteQuery()
    {
        $query = $this->_sut->createFleaMarketOrganizerDeleteQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerDeleteQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketOrganizerInsertQuery()
    {
        $query = $this->_sut->createFleaMarketOrganizerInsertQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketOrganizerReadListQuery()
    {
        $query = $this->_sut->createFleaMarketOrganizerReadListQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadListQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaOrganizerMarketReadQuery()
    {
        $query = $this->_sut->createFleaMarketOrganizerReadQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketOrganizerUpdateQuery()
    {
        $query = $this->_sut->createFleaMarketOrganizerUpdateQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerUpdateQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketDetailsDeleteQuery()
    {
        $query = $this->_sut->createFleaMarketDetailsDeleteQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsDeleteQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketDetailsInsertQuery()
    {
        $query = $this->_sut->createFleaMarketDetailsInsertQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsInsertQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketDetailsReadListQuery()
    {
        $query = $this->_sut->createFleaMarketDetailsReadListQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsReadListQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketDetailsReadQuery()
    {
        $query = $this->_sut->createFleaMarketDetailsReadQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsReadQuery',
            $query
        );
    }

    public function testFactoryCreatesFleaMarketDetailsUpdateQuery()
    {
        $query = $this->_sut->createFleaMarketDetailsUpdateQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDetailsUpdateQuery',
            $query
        );
    }
}
