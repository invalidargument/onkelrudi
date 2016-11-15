<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;
    private $_fleaMarketService;
    private $_organizerService;

    protected function setUp()
    {
        $this->_sut = new FleaMarketUpdateQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);

        $this->_fleaMarketService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface');
        $this->_organizerService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');

        $this->_sut->setFleaMarketService($this->_fleaMarketService);
        $this->_sut->setOrganizerService($this->_organizerService);
    }

    public function testQueryUsesGivenValuesForRunningUpdateStatement()
    {
        $dates = array(new FleaMarketDate('2018-01-01 10:00:00', '2018-01-01 18:00:00'));
        $this->_fleaMarketService->shouldReceive('deleteDates')->once()->with(23)
            ->shouldReceive('createDates')->once()->with(23, $dates);

        $organizer = new Organizer();
        $organizer->setId(42);
        $this->_organizerService->shouldReceive('updateOrganizer')->once()->with($organizer);

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
            ->setUrl('http://www.exmple.com')
            ->setOrganizer($organizer);

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
                    'url' => $fleaMarket->getUrl(),
                    'organizer_id' => 42
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
