<?php

namespace RudiBieller\OnkelRudi\User;

class LoginQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;
    private $_fleaMarketService;

    protected function setUp()
    {
        $this->_sut = new LoginQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryUserById()
    {
        $this->_sut->setIdentifier('foo@example.com');

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn('thehash');

        $this->_pdo
            ->shouldReceive('select')
                ->andReturn($this->_pdo)
                ->shouldReceive('from')
                ->with('fleamarkets_users')
                    ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->with('email', '=', 'foo@example.com')
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);

        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $hash = $this->_sut->run();

        $this->assertEquals('thehash', $hash);
    }
}
