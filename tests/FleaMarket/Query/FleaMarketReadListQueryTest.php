<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketReadListQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryReadsFleaMarketsByDefaultLimitAndOffset()
    {
        $service = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface');
        $service
            ->shouldReceive('getDates')->once()->with(42)->andReturn([])
            ->shouldReceive('getDates')->once()->with(23)->andReturn([]);
        $this->_sut->setFleaMarketService($service);

        $validFleaMarketIds = [1,2,3];

        $result = array(
            array(
                'id' => 42,
                'uuid' => 'uuid',
                'organizer_id' => '1',
                'name' => 'Rudi Bieller',
                'description' => 'foo',
                'dates' => [],
                'street' => 'bar',
                'streetno' => '1',
                'city' => 'baz',
                'zipcode' => '12345',
                'location' => 'somewhereovertherainbow',
                'url' => 'http://www.example.com'
            ),
            array(
                'id' => 23,
                'uuid' => 'uuid-uuid',
                'organizer_id' => '1',
                'name' => 'Rudi Bieller',
                'description' => 'foo',
                'dates' => [],
                'street' => 'bar',
                'streetno' => '1',
                'city' => 'baz',
                'zipcode' => '12345',
                'location' => 'somewhereovertherainbow',
                'url' => 'http://www.example.com'
            )
        );

        $statement1 = \Mockery::mock('\PDOStatement');
        $statement1->shouldReceive('fetchAll')
            ->once()
            ->andReturn($validFleaMarketIds);
        $statement2 = \Mockery::mock('\PDOStatement');
        $statement2->shouldReceive('fetchAll')
            ->once()
            ->andReturn($result);

        $this->_pdo
            ->shouldReceive('select')
                ->once()
                ->with(['fleamarket_id'])
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->once()
                ->with('fleamarkets_dates')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('start', '>=', date('Y-m-d 00:00:00'))
                ->andReturn($this->_pdo)
            ->shouldReceive('groupBy')
                ->once()
                ->with('fleamarket_id')
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement1)
            ->shouldReceive('fetch')
                ->once()
                ->with(\PDO::FETCH_ASSOC)
                ->andReturn($validFleaMarketIds);

        $this->_pdo
            ->shouldReceive('select')
                ->once()
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->once()
                ->with('fleamarkets')
                ->andReturn($this->_pdo)
            ->shouldReceive('whereIn')
                ->once()
                ->with('id', $validFleaMarketIds)
                ->andReturn($this->_pdo)
            ->shouldReceive('limit')
                ->once()
                ->with(20)
                ->andReturn($this->_pdo)
            ->shouldReceive('offset')
                ->once()
                ->with(0)
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement2)
            ->shouldReceive('fetch')
                ->once();
        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarkets = $this->_sut->run();

        $this->assertInternalType('array', $fleaMarkets);
        $this->assertSame(2, count($fleaMarkets));

        $this->assertEquals(23, $fleaMarkets[0]->getId());
        $this->assertEquals(42, $fleaMarkets[1]->getId());
    }
}
