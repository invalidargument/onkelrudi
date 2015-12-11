<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new Factory();
    }

    /**
     * @dataProvider dataProviderTestFactoryCreatesDesiredQuery
     */
    public function testFactoryCreatesDesiredQuery($method, $expectedQuery)
    {
        $query = $this->_sut->$method();

        $this->assertInstanceOf(
            $expectedQuery,
            $query
        );
    }

    public function dataProviderTestFactoryCreatesDesiredQuery()
    {
        return array(
            array('createFleaMarketDeleteQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketDeleteQuery'),
            array('createFleaMarketInsertQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketInsertQuery'),
            array('createFleaMarketReadListQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadListQuery'),
            array('createFleaMarketReadQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketReadQuery'),
            array('createFleaMarketUpdateQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketUpdateQuery'),
            array('createFleaMarketOrganizerDeleteQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerDeleteQuery'),
            array('createFleaMarketOrganizerInsertQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery'),
            array('createFleaMarketOrganizerReadListQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadListQuery'),
            array('createFleaMarketOrganizerReadQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadQuery'),
            array('createFleaMarketOrganizerUpdateQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerUpdateQuery'),
            array('createFleaMarketTestCaseDeleteQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketTestCaseDeleteQuery')
        );
    }
}
