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
        $result = array(
            array(
                'id' => 42,
                'organizer_id' => '1',
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
            ),
            array(
                'id' => 23,
                'organizer_id' => '1',
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
            )
        );

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetchAll')
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
                ->with('start', '>=', date('Y-m-d 00:00:00'))
                ->andReturn($this->_pdo)
            ->shouldReceive('orderBy')
                ->once()
                ->with('start', 'ASC')
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
                ->andReturn($statement);
        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarkets = $this->_sut->run();

        $this->assertInternalType('array', $fleaMarkets);
        $this->assertSame(2, count($fleaMarkets));

        $this->assertEquals(42, $fleaMarkets[0]->getId());
        $this->assertEquals(23, $fleaMarkets[1]->getId());
    }
}
