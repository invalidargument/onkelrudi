<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketTestCaseDeleteQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryExecutesTruncateQueries()
    {
        $query = new FleaMarketTestCaseDeleteQuery();
        $pdo = \Mockery::mock('\Slim\PDO\Database');
        $query->setPdo($pdo);

        $pdo
            ->shouldReceive('exec')
                ->once()
                ->with('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets; SET FOREIGN_KEY_CHECKS = 1;')
                ->andReturn(20)
            ->shouldReceive('exec')
                ->once()
                ->with('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_organizer; SET FOREIGN_KEY_CHECKS = 1;')
                ->andReturn(40)
            ->shouldReceive('exec')
                ->once()
                ->with('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_dates; SET FOREIGN_KEY_CHECKS = 1;')
                ->andReturn(80)
            ->shouldReceive('exec')
                ->once()
                ->with('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_users; SET FOREIGN_KEY_CHECKS = 1;')
                ->andReturn(100);
        $query->run();
    }
}
