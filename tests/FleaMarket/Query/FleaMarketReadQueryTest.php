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
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface');
        $service->shouldReceive('getDates')->once()->with(23)->andReturn([]);

        $this->_sut
            ->setFleaMarketService($service)
            ->setFleaMarketId(23);

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
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface');
        $service->shouldReceive('getDates')->once()->with(23)->andReturn([]);

        $this->_sut
            ->setFleaMarketService($service)
            ->setFleaMarketId(23);

        $result = array(
            'id' => 42,
            'uuid' => 'uuid',
            'organizer_id' => '55',
            'name' => 'Hänsel & Gretel warten in Dänemark',
            'description' => 'foo',
            'dates' => [],
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
        $this->assertEquals('uuid', $fleaMarket->getUuid());
        $this->assertEquals('Hänsel & Gretel warten in Dänemark', $fleaMarket->getName());
        $this->assertEquals('haensel-gretel-warten-in-daenemark-baz', $fleaMarket->getSlug());
        $this->assertEquals('foo', $fleaMarket->getDescription());
        $this->assertEquals('bar', $fleaMarket->getStreet());
        $this->assertEquals([], $fleaMarket->getDates());
        $this->assertEquals('1', $fleaMarket->getStreetNo());
        $this->assertEquals('baz', $fleaMarket->getCity());
        $this->assertEquals('12345', $fleaMarket->getZipCode());
        $this->assertEquals('somewhereovertherainbow', $fleaMarket->getLocation());
        $this->assertEquals('http://www.example.com', $fleaMarket->getUrl());
    }
}
