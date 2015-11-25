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
                'name' => 'Rudi Bieller',
                'organizer_id' => '1'
            ),
            array(
                'id' => 23,
                'name' => 'Rudi',
                'organizer_id' => '2'
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
