<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\User\User;
use RudiBieller\OnkelRudi\User\UserBuilder;
use Slim\Container;

class FleaMarketReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $di = new Container([
            'UserBuilder' => function ($c) {
                return new UserBuilder();
            }
        ]);
        $this->_sut = new FleaMarketReadListQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
        $this->_sut->setDiContainer($di);
    }

    protected function tearDown()
    {
        parent::tearDown();
        //\Mockery::close();
    }

    public function testQueryReadsFleaMarketsByDefaultLimitAndOffset()
    {
        $datesData = [
            ['fleamarket_id' => 42, 'start' => '2018-03-04 10:00:00', 'end' => '2018-03-04 18:00:00'],
            ['fleamarket_id' => 23, 'start' => '2018-05-04 10:00:00', 'end' => '2018-05-04 18:00:00']
        ];

        $marketsData = array(
            array(
                'id' => 42,
                'uuid' => 'uuid',
                'organizer_id' => '1',
                'user_id' => 'info@onkel-rudi.de',
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
                'user_id' => 'info@onkel-rudi.de',
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
        $statement1->shouldReceive('fetchAll')->once()->andReturn($datesData);

        $statement2 = \Mockery::mock('\PDOStatement');
        $statement2->shouldReceive('fetchAll')->once()->andReturn($marketsData);

        // query dates
        $this->_pdo->shouldReceive('select->from->orderBy->limit->offset')->andReturn($this->_pdo);
        $this->_pdo->shouldReceive('execute')->once()->andReturn($statement1);

        // query markets
        $this->_pdo->shouldReceive('select->from->whereIn->where')->andReturn($this->_pdo);
        $this->_pdo->shouldReceive('execute')->once()->andReturn($statement2);

        $user = new User('info@onkel-rudi.de');
        $this->_sut->setUser($user);

        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarkets = $this->_sut->run();

        $this->assertInternalType('array', $fleaMarkets);
        $this->assertSame(2, count($fleaMarkets));

        $this->assertEquals(42, $fleaMarkets[0]->getId());
        $this->assertEquals(23, $fleaMarkets[1]->getId());
    }

    public function testQueryReadsFleaMarketsBySpecifiedInterval()
    {
        $start = new \DateTimeImmutable();
        $end = new \DateTimeImmutable(
            $start->add(new \DateInterval('P1M'))->format('Y-m-t 23:59:59')
        );

        $this->_sut->setQueryTimespan($start, $end);

        $statement1 = \Mockery::mock('\PDOStatement');
        $statement1->shouldReceive('fetchAll')->once()->andReturn([]);

        // query dates
        $this->_pdo->shouldReceive('select')->once()->andReturn($this->_pdo)
            ->shouldReceive('from')->once()->with('fleamarkets_dates')->andReturn($this->_pdo)
            ->shouldReceive('where')->once()->with('start', '>=', date('Y-m-d 00:00:00'))->andReturn($this->_pdo)
            ->shouldReceive('where')->once()->with('end', '<=', date('Y-m-t 23:59:59', strtotime('+1 months')))->andReturn($this->_pdo)
            ->shouldReceive('limit')->once()->andReturn($this->_pdo)
            ->shouldReceive('orderBy')->once()->andReturn($this->_pdo)
            ->shouldReceive('offset')->once()->andReturn($this->_pdo)
            ->shouldReceive('execute')->once()->andReturn($statement1);

        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarket
         */
        $fleaMarkets = $this->_sut->run();

        $this->assertInternalType('array', $fleaMarkets);
    }
}
