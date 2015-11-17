<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class FleaMarketUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketUpdateQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryUsesGivenValuesForRunningUpdateStatement()
    {
        $fleaMarket = new FleaMarket();
        $fleaMarket->setId(23)
            ->setName('foo')
            ->setOrganizerId('77');

        $this->_sut
            ->setFleaMarket($fleaMarket);

        $this->_pdo
            ->shouldReceive('update')
                ->once()
                ->with(array(
                    'name' => $fleaMarket->getName(),
                    'organizer_id' => $fleaMarket->getOrganizerId()
                ))
                ->andReturn($this->_pdo)
            ->shouldReceive('table')
                ->once()
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('id', '=', $fleaMarket->getId())
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once();
        $this->_sut->run();
    }
}
