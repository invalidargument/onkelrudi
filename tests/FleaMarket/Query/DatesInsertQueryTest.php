<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;

class DatesInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryInsertsEverySingleStartEndCombination()
    {
        $sut = new DatesInsertQuery();
        $pdo = \Mockery::mock('\Slim\PDO\Database');
        $sut->setPdo($pdo);

        $date1 = new FleaMarketDate(new \DateTime('2016-01-23 09:30:00'), new \DateTime('2016-01-23 20:30:00'));
        $date2 = new FleaMarketDate(new \DateTime('2016-01-23 10:30:00'), new \DateTime('2016-01-23 21:30:00'));
        $date3 = new FleaMarketDate(new \DateTime('2016-01-23 11:30:00'), new \DateTime('2016-01-23 22:30:00'));

        $fleaMarketDate1s = [
            $date1, $date2, $date3
        ];

        $sut->setDates($fleaMarketDate1s)->setFleaMarketId(42);

        $pdo
            ->shouldReceive('insert')
                ->times(3)
                ->with(array('fleamarket_id', 'start', 'end'))
                ->andReturn($pdo)
            ->shouldReceive('into')
                ->times(3)
                ->with('fleamarkets_dates')
                ->andReturn($pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array(42, $date1->getStart(), $date1->getEnd()))
                ->andReturn($pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array(42, $date2->getStart(), $date2->getEnd()))
                ->andReturn($pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array(42, $date3->getStart(), $date3->getEnd()))
                ->andReturn($pdo)
            ->shouldReceive('execute');

        $sut->run();
    }
}
