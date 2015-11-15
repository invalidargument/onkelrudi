<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new Factory();
    }

    public function testFactoryCreatesFleaMarketQuery()
    {
        $query = $this->_sut->createFleaMarketQuery();

        $this->assertInstanceOf(
            'RudiBieller\OnkelRudi\FleaMarket\Query\FleaMarketOrganizerInsertQuery',
            $query
        );
    }
}
