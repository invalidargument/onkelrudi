<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Slim\Container;

class OrganizerQueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new OrganizerQueryFactory();
        $this->_sut->setDiContainer(new Container());
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
            array('createFleaMarketOrganizerDeleteQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerDeleteQuery'),
            array('createFleaMarketOrganizerInsertQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery'),
            array('createFleaMarketOrganizerReadListQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadListQuery'),
            array('createFleaMarketOrganizerReadQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerReadQuery'),
            array('createFleaMarketOrganizerByUserReadQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerByUserReadQuery'),
            array('createFleaMarketOrganizerUpdateQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerUpdateQuery'),
        );
    }
}
