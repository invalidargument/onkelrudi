<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use Slim\Container;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $containerConfig = [
            'OrganizerService' => function ($c) {
                return \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');
            }
        ];
        $this->_sut = new Factory();
        $this->_sut->setDiContainer(new Container($containerConfig));
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
            array('createFleaMarketTestCaseDeleteQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketTestCaseDeleteQuery'),
            array('createFleaMarketDatesInsertQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\DatesInsertQuery'),
            array('createFleaMarketDatesReadListQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\DatesReadListQuery'),
            array('createFleaMarketDatesDeleteQuery', 'RudiBieller\OnkelRudi\FleaMarket\Query\DatesDeleteQuery')
        );
    }
}
