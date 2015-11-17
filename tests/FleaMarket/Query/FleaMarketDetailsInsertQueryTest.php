<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketDetailsInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketDetailsInsertQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryUsesGivenValuesForRunningInsertStatement()
    {
        $this->_sut
            ->setFleaMarketId('23')
            ->setDescription('foo')
            ->setStart('2015-12-12 00:00:00')
            ->setEnd('2015-12-13 00:00:00')
            ->setStreet('bar')
            ->setStreetNo('42')
            ->setCity('baz')
            ->setZipCode('12345')
            ->setLocation('somewhere')
            ->setUrl('http://www.example.com');

        $this->_pdo
            ->shouldReceive('insert')
                ->once()
                ->with(array('fleamarket_id', 'description', 'start', 'end', 'street', 'streetno', 'city', 'zipcode', 'location', 'url'))
                ->andReturn($this->_pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets_details')
                ->andReturn($this->_pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array('23', 'foo', '2015-12-12 00:00:00', '2015-12-13 00:00:00', 'bar', '42', 'baz', '12345', 'somewhere', 'http://www.example.com'))
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once();
        $this->_sut->run();
    }
}
