<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetails;

class FleaMarketDetailsUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketDetailsUpdateQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryUsesGivenValuesForRunningUpdateStatement()
    {
        $details = new FleaMarketDetails();
        $details->setId(23)
            ->setFleaMarketId('2222')
            ->setDescription('fooobaaarbaaaz')
            ->setStart('2015-12-22 00:00:00')
            ->setEnd('2015-12-22 00:00:01')
            ->setStreet('foooo')
            ->setStreetNo('77')
            ->setCity('Cologne')
            ->setZipCode('50667')
            ->setLocation('hall')
            ->setUrl('http://www.exmple.com');

        $this->_sut
            ->setDetails($details);

        $this->_pdo
            ->shouldReceive('update')
                ->once()
                ->with(array(
                    'fleamarket_id' => $details->getFleaMarketId(),
                    'description' => $details->getDescription(),
                    'start' => $details->getStart(),
                    'end' => $details->getEnd(),
                    'street' => $details->getStreet(),
                    'streetno' => $details->getStreetNo(),
                    'city' => $details->getCity(),
                    'zipcode' => $details->getZipCode(),
                    'location' => $details->getLocation(),
                    'url' => $details->getUrl()
                ))
                ->andReturn($this->_pdo)
            ->shouldReceive('table')
                ->once()
                ->with('fleamarkets_details')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('id', '=', $details->getId())
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once();
        $this->_sut->run();
    }
}
