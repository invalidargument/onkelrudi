<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;

class DatesReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        parent::setUp();
        $this->_sut = new DatesReadListQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    protected function tearDown()
    {
        parent::tearDown();
        //\Mockery::close();
    }

    public function testQueryReadsDatesByFleaMarketIdIncludingPassedDates()
    {
        $result = array(
            array(
                'start' => '2017-01-01 10:00:00',
                'end' => '2017-01-02 18:00:00'
            ),
            array(
                'start' => '2017-02-01 10:23:42',
                'end' => '2017-02-02 18:23:42'
            )
        );

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetchAll')
            ->once()
            ->andReturn($result);

        $this->_pdo
            ->shouldReceive('select')
                ->once()
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->once()
                ->with('fleamarkets_dates')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('fleamarket_id', '=', '123')
                ->andReturn($this->_pdo)
            ->shouldReceive('orderBy')
                ->once()
                ->with('start', 'ASC')
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);
        /**
         * @var FleaMarketDate[]
         */
        $dates = $this->_sut
            ->setFleaMarketId(123)
            ->run();

        $this->assertInternalType('array', $dates);
        $this->assertSame(2, count($dates));

        $this->assertEquals('2017-01-01 10:00:00', $dates[0]->getStart());
        $this->assertEquals('2017-02-01 10:23:42', $dates[1]->getStart());
    }

    /**
     * @dataProvider dataProviderTestQuerySelectsDatesDependingOnRequestingOnlyUpcomingDatesOrNot
     */
    public function testQuerySelectsDatesDependingOnRequestingOnlyUpcomingDatesOrNot($queryOnlyCurrent, $times)
    {
        $result = array(
            array(
                'start' => '2017-01-01 10:00:00',
                'end' => '2017-01-02 18:00:00'
            )
        );

        $this->_sut->setQueryOnlyCurrentDates($queryOnlyCurrent);

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetchAll')
            ->once()
            ->andReturn($result);

        $this->_pdo
            ->shouldReceive('select')
                ->once()
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->once()
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('fleamarket_id', '=', '123')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->times($times)
                ->with('start', '>=', date('Y-m-d 00:00:00'))
                ->andReturn($this->_pdo)
            ->shouldReceive('orderBy')
                ->once()
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);
        /**
         * @var FleaMarketDate[]
         */
        $dates = $this->_sut
            ->setFleaMarketId(123)
            ->run();

        $this->assertSame(1, count($dates));
        $this->assertEquals('2017-01-01 10:00:00', $dates[0]->getStart());
    }

    public function dataProviderTestQuerySelectsDatesDependingOnRequestingOnlyUpcomingDatesOrNot()
    {
        return array(
            array(true, 1),
            array(false, 0)
        );
    }
}
