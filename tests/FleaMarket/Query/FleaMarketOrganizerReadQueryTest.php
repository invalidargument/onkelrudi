<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketOrganizerReadQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new FleaMarketOrganizerReadQuery();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    public function testQueryReadsUserByIdIfNotFound()
    {
        $this->_sut->setOrganizerId(23);

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn(false);

        $this->_pdo
            ->shouldReceive('select')
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->with('fleamarkets_organizer')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);

        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
         */
        $organizer = $this->_sut->run();

        $this->assertEquals(null, $organizer->getId());
    }

    public function testQueryReadsUserByIdIfFound()
    {
        $this->_sut->setOrganizerId(23);

        $result = array(
            'id' => 42,
            'uuid' => 'uuid',
            'name' => 'Rudi Bieller',
            'street' => 'Foo Street',
            'streetno' => 23,
            'city' => 'Cologne',
            'zipcode' => 50667,
            'phone' => '0123456',
            'email' => 'baz@example.com',
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
                ->with('fleamarkets_organizer')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('id', '=', 23)
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);
        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
         */
        $organizer = $this->_sut->run();

        $this->assertEquals(42, $organizer->getId());
        $this->assertEquals('uuid', $organizer->getUuid());
        $this->assertEquals('Rudi Bieller', $organizer->getName());
        $this->assertEquals('Foo Street', $organizer->getStreet());
        $this->assertEquals(23, $organizer->getStreetNo());
        $this->assertEquals('Cologne', $organizer->getCity());
        $this->assertEquals(50667, $organizer->getZipCode());
        $this->assertEquals('0123456', $organizer->getPhone());
        $this->assertEquals('baz@example.com', $organizer->getEmail());
        $this->assertEquals('http://www.example.com', $organizer->getUrl());
    }
}
