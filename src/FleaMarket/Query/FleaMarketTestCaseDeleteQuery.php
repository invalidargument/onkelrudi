<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketInterface;

class FleaMarketTestCaseDeleteQuery extends AbstractInsertQuery
{
    protected function runQuery()
    {
        $affected1 = $this->pdo
            ->exec('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets; SET FOREIGN_KEY_CHECKS = 1;');
        $affected2 = $this->pdo
            ->exec('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_organizer; SET FOREIGN_KEY_CHECKS = 1;');
        $affected3 = $this->pdo
            ->exec('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_dates; SET FOREIGN_KEY_CHECKS = 1;');
        $affected4 = $this->pdo
            ->exec(
                "SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_users; ".
                "INSERT INTO fleamarkets_users (email, password, type, opt_in) VALUES ('verstaerker@gmx.net', '$2y$10$4AP8/lcBd/TY9xvki3Nd9uyF3kCr11llULtkIV34dHqrJhjjXyMLe', 'admin', 1); ".
                "INSERT INTO fleamarkets_users (email, password, type, opt_in) VALUES ('test@onkel-rudi.de', '$2y$10$5OMCRF2m6KDcKLF1qV20Det5DzDAwga9An3hK84OeVMi/WjYDwkOy', 'user', 1); ".
                "SET FOREIGN_KEY_CHECKS = 1;"
            );
        $affected5 = $this->pdo
            ->exec('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE fleamarkets_optins; SET FOREIGN_KEY_CHECKS = 1;');

        return $affected1 + $affected2 + $affected3 + $affected4 + $affected5;
    }
}
