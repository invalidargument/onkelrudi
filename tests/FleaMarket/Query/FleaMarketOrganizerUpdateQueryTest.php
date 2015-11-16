<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketOrganizerUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketOrganizerUpdateQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryUsesGivenValuesForRunningUpdateStatement()
    {
        $organizer = new Organizer();
        $organizer->setId(23)
            ->setName('foo')
            ->setCity('Cologne')
            ->setZipCode(50667)
            ->setPhone('0221123456')
            ->setUrl('http://www.example.com')
            ->setStreet('abc')
            ->setStreetNo('42');

        $this->_sut
            ->setorganizer($organizer);

        $this->_pdo
            ->shouldReceive('update')
                ->once()
                ->with(array(
                    'name' => $organizer->getName(),
                    'street' => $organizer->getStreet(),
                    'streetno' => $organizer->getStreetNo(),
                    'city' => $organizer->getCity(),
                    'zipcode' => $organizer->getZipCode(),
                    'phone' => $organizer->getPhone(),
                    'url' => $organizer->getUrl()
                ))
                ->andReturn($this->_pdo)
            ->shouldReceive('table')
                ->once()
                ->with('fleamarkets_organizer')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('id', '=', $organizer->getId())
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once();
        $this->_sut->run();
    }
}
