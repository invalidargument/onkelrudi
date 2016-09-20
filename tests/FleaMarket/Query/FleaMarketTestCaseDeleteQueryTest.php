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
                ->with('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_users; INSERT INTO fleamarkets_users (email, password, type, opt_in) VALUES (\'verstaerker@gmx.net\', \'$2y$10$4AP8/lcBd/TY9xvki3Nd9uyF3kCr11llULtkIV34dHqrJhjjXyMLe\', \'admin\', 1); INSERT INTO fleamarkets_users (email, password, type, opt_in) VALUES (\'test@onkel-rudi.de\', \'$2y$10$5OMCRF2m6KDcKLF1qV20Det5DzDAwga9An3hK84OeVMi/WjYDwkOy\', \'user\', 1); INSERT INTO fleamarkets_users (email, password, type, opt_in) VALUES (\'info@onkel-rudi.de\', \'$2y$10$5OMCRF2m6KDcKLF1qV20Det5DzDAwga9An3hK84OeVMi/WjYDwkOy\', \'user\', 1); SET FOREIGN_KEY_CHECKS = 1;')
                ->andReturn(100)

            ->shouldReceive('exec')
                ->once()
                ->with('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_optins; SET FOREIGN_KEY_CHECKS = 1;')
                ->andReturn(80);
        $query->run();
    }
}
