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

    public function testQueryReadsDefaultEmptyFleaMarketsByIdIfNotFoundInDb()
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
        $fleaMarket = $this->_sut->runQuery();

        $this->assertEquals(null, $fleaMarket->getId());
    }

    public function testQueryReadsUserByIdIfFound()
    {
        $this->_sut->setFleaMarketId(23);

        $result = array(
            'id' => 42,
            'name' => 'Rudi Bieller',
            'organizer_id' => '55'
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
        $fleaMarket = $this->_sut->runQuery();

        $this->assertEquals(42, $fleaMarket->getId());
        $this->assertEquals('Rudi Bieller', $fleaMarket->getName());
        $this->assertEquals('55', $fleaMarket->getOrganizerId());
    }
}
