<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketOrganizerReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketOrganizerReadListQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryReadsUsersByDefaultLimitAndOffset()
    {
        $result = array(
            array(
                'id' => 42,
                'name' => 'Rudi Bieller',
                'street' => 'Foo Street',
                'streetno' => 23,
                'city' => 'Cologne',
                'zipcode' => 50667,
                'phone' => '0123456',
                'url' => 'http://www.example.com'
            ),
            array(
                'id' => 23,
                'name' => 'Rudi',
                'street' => 'Foo',
                'streetno' => 2,
                'city' => 'Ehrenfeld',
                'zipcode' => 50825,
                'phone' => '0123456789',
                'url' => 'http://www.example.com/foo'
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
                ->with('fleamarkets_organizer')
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
         * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
         */
        $organizers = $this->_sut->runQuery();

        $this->assertInternalType('array', $organizers);
        $this->assertSame(2, count($organizers));

        $this->assertEquals(42, $organizers[0]->getId());
        $this->assertEquals(23, $organizers[1]->getId());
    }
}
