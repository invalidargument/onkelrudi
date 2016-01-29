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

        return $affected1 + $affected2 + $affected3;
    }
}
