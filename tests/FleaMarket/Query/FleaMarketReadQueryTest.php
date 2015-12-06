<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketReadQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketReadQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryReturnsNullIfNotFoundInDb()
    {
        $this->_sut->setFleaMarketId(23);

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn(false);

        $this->_pdo
            ->shouldReceive('select')
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);

        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarket = $this->_sut->run();

        $this->assertEquals(null, $fleaMarket);
    }

    public function testQueryReadsMarketByIdIfFound()
    {
        $this->_sut->setFleaMarketId(23);

        $result = array(
            'id' => 42,
            'organizer_id' => '55',
            'name' => 'Rudi Bieller',
            'description' => 'foo',
            'start' => '2015-12-12 00:00:00',
            'end' => '2015-12-13 00:00:00',
            'street' => 'bar',
            'streetno' => '1',
            'city' => 'baz',
            'zipcode' => '12345',
            'location' => 'somewhereovertherainbow',
            'url' => 'http://www.example.com'
        );

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn($result);

        $this->_pdo
            ->shouldReceive('select')
                ->once()
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->once()
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('id', '=', 23)
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);
        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarket = $this->_sut->run();

        $this->assertEquals(42, $fleaMarket->getId());
        $this->assertEquals('Rudi Bieller', $fleaMarket->getName());
        $this->assertEquals('foo', $fleaMarket->getDescription());
        $this->assertEquals('2015-12-12 00:00:00', $fleaMarket->getStart());
        $this->assertEquals('2015-12-13 00:00:00', $fleaMarket->getEnd());
        $this->assertEquals('bar', $fleaMarket->getStreet());
        $this->assertEquals('1', $fleaMarket->getStreetNo());
        $this->assertEquals('baz', $fleaMarket->getCity());
        $this->assertEquals('12345', $fleaMarket->getZipCode());
        $this->assertEquals('somewhereovertherainbow', $fleaMarket->getLocation());
        $this->assertEquals('http://www.example.com', $fleaMarket->getUrl());
    }
}
