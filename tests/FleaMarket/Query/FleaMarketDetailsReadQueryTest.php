<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketDetailsReadQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketDetailsReadQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryReadsDefaultEmptyDetailsByIdIfNotFoundInDb()
    {
        $this->_sut->setDetailsId(23);

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn(false);

        $this->_pdo
            ->shouldReceive('select')
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->with('fleamarkets_details')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);

        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarket = $this->_sut->runQuery();

        $this->assertEquals(null, $fleaMarket->getId());
    }

    public function testQueryReadsDetailsByIdIfFound()
    {
        $this->_sut->setDetailsId(23);

        $result = array(
            'id' => 42,
            'fleamarket_id' => '222',
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
                ->with('fleamarkets_details')
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
        $details = $this->_sut->runQuery();

        $this->assertEquals(42, $details->getId());
        $this->assertEquals('222', $details->getFleaMarketId());
        $this->assertEquals('foo', $details->getDescription());
        $this->assertEquals('2015-12-12 00:00:00', $details->getStart());
        $this->assertEquals('2015-12-13 00:00:00', $details->getEnd());
        $this->assertEquals('bar', $details->getStreet());
        $this->assertEquals('1', $details->getStreetNo());
        $this->assertEquals('baz', $details->getCity());
        $this->assertEquals('12345', $details->getZipCode());
        $this->assertEquals('somewhereovertherainbow', $details->getLocation());
        $this->assertEquals('http://www.example.com', $details->getUrl());
    }
}
