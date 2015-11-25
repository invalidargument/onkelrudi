<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketDetailsReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketDetailsReadListQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryReadsDetailsByDefaultLimitAndOffset()
    {
        $result = array(
            array(
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
                ->with('fleamarkets_details')
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
        $details = $this->_sut->run();

        $this->assertInternalType('array', $details);
        $this->assertSame(1, count($details));

        $this->assertEquals(42, $details[0]->getId());
    }
}
