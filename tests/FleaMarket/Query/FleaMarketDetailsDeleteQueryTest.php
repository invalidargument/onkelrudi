<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketDetailsDeleteQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketDetailsDeleteQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryDeletesDetails()
    {
        $this->_sut->setFleaMarketDetailsId(23);

        $this->_pdo
            ->shouldReceive('delete')
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
                ->once();
        $this->_sut->run();
    }
}
