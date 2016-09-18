<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;

class FleaMarketUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketUpdateQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);

        $this->_fleaMarketService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface');
        $this->_sut->setFleaMarketService($this->_fleaMarketService);
    }

    public function testQueryUsesGivenValuesForRunningUpdateStatement()
    {
        $dates = array(new FleaMarketDate('2018-01-01 10:00:00', '2018-01-01 18:00:00'));
        $this->_fleaMarketService->shouldReceive('replaceDates')->once()->with(23, $dates);

        $fleaMarket = new FleaMarket();
        $fleaMarket
            ->setId(23)
            ->setName('foo')
            ->setDescription('fooobaaarbaaaz')
            ->setDates($dates)
            ->setStreet('foooo')
            ->setStreetNo('77')
            ->setCity('Cologne')
            ->setZipCode('50667')
            ->setLocation('hall')
            ->setUrl('http://www.exmple.com');

        $this->_sut
            ->setFleaMarket($fleaMarket);

        $this->_pdo
            ->shouldReceive('beginTransaction')->andReturn($this->_pdo)
            ->shouldReceive('commit')->andReturn($this->_pdo)
            ->shouldReceive('update')
                ->once()
                ->with(array(
                    'name' => $fleaMarket->getName(),
                    'description' => $fleaMarket->getDescription(),
                    'street' => $fleaMarket->getStreet(),
                    'streetno' => $fleaMarket->getStreetNo(),
                    'city' => $fleaMarket->getCity(),
                    'zipcode' => $fleaMarket->getZipCode(),
                    'location' => $fleaMarket->getLocation(),
                    'url' => $fleaMarket->getUrl()
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
