<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;

class FleaMarketInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;
    private $_fleaMarketService;

    protected function setUp()
    {
        $this->_sut = new FleaMarketInsertQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);

        $this->_fleaMarketService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketService');
        $this->_sut->setFleaMarketService($this->_fleaMarketService);
    }

    public function testQueryUsesGivenValuesForRunningInsertStatement()
    {
        $dates = array(new FleaMarketDate());
        $this->_fleaMarketService->shouldReceive('createDates')->once()->with(1, $dates);

        $this->_sut
            ->setOrganizerId('42')
            ->setUserId('test@onkel-rudi.de')
            ->setName('myname')
            ->setDescription('foo')
            ->setDates($dates)
            ->setStreet('bar')
            ->setStreetNo('42')
            ->setCity('baz')
            ->setZipCode('12345')
            ->setLocation('somewhere')
            ->setUrl('http://www.example.com');

        $this->_pdo
            ->shouldReceive('beginTransaction')->andReturn($this->_pdo)
            ->shouldReceive('commit')->andReturn($this->_pdo)
            ->shouldReceive('insert')
                ->once()
                ->with(array('uuid', 'organizer_id', 'user_id', 'name', 'description', 'street', 'streetno', 'city', 'zipcode', 'location', 'url', 'approved', 'opt_in_dsgvo', 'opt_in_dsgvo_ts'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
            //->with(array('3a90a517-d603-580c-a1bf-5fc43438448f', '42', 'test@onkel-rudi.de', 'myname', 'foo', 'bar', '42', 'baz', '12345', 'somewhere', 'http://www.example.com', '0', true, \Mockery::any()))
                // TODO
            ->with(\Mockery::any())
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn(1);
        $this->_sut->run();

        $this->markTestIncomplete('TODO DSGVO');
    }

    /**
     * @dataProvider dataProviderTestSettingApprovedState
     */
    public function testSettingApprovedState($approved, $expected)
    {
        $dates = array(new FleaMarketDate());
        $this->_fleaMarketService->shouldReceive('createDates')->once()->with(1, $dates);

        $this->_sut
            ->setOrganizerId('42')
            ->setUserId('test@onkel-rudi.de')
            ->setName('myname')
            ->setDescription('foo')
            ->setDates($dates)
            ->setStreet('bar')
            ->setStreetNo('42')
            ->setCity('baz')
            ->setZipCode('12345')
            ->setLocation('somewhere')
            ->setUrl('http://www.example.com')
            ->setApproved($approved);

        $this->_pdo
            ->shouldReceive('beginTransaction')->andReturn($this->_pdo)
            ->shouldReceive('commit')->andReturn($this->_pdo)
            ->shouldReceive('insert')
                ->once()
                ->with(array('uuid', 'organizer_id', 'user_id', 'name', 'description', 'street', 'streetno', 'city', 'zipcode', 'location', 'url', 'approved', 'opt_in_dsgvo', 'opt_in_dsgvo_ts'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
            //->with(array('3a90a517-d603-580c-a1bf-5fc43438448f', '42', 'test@onkel-rudi.de', 'myname', 'foo', 'bar', '42', 'baz', '12345', 'somewhere', 'http://www.example.com', $expected, true, \Mockery::any()))
                //TODO
            ->with(\Mockery::any())
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn(1);
        $this->_sut->run();

        $this->markTestIncomplete('TODO DSGVO');
    }

    public function dataProviderTestSettingApprovedState()
    {
        return array(
            array(true, '1'),
            array(false, '0'),
            array(null, '0')
        );
    }
}
