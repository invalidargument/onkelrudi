<?php

namespace RudiBieller\OnkelRudi\FleaMarket\Query;

class FleaMarketOrganizerByUserReadQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryReadsUserByIdIfFound()
    {
        $sut = new FleaMarketOrganizerByUserReadQuery();
        $pdo = \Mockery::mock('\Slim\PDO\Database');
        $sut->setPdo($pdo);

        $sut->setUserId('foo@example.com');

        $result = array(
            'id' => 42,
            'uuid' => 'uuid',
            'name' => 'Rudi Bieller',
            'street' => 'Foo Street',
            'streetno' => 23,
            'city' => 'Cologne',
            'zipcode' => 50667,
            'phone' => '0123456',
            'email' => 'foo@example.com',
            'url' => 'http://www.example.com'
        );

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn($result);

        $pdo
            ->shouldReceive('select')
                ->once()
                ->andReturn($pdo)
            ->shouldReceive('from')
                ->once()
                ->with('fleamarkets_organizer')
                ->andReturn($pdo)
            ->shouldReceive('join')
                ->once()
                ->with('fleamarkets_user_to_organizer', 'fleamarkets_organizer.id', '=', 'fleamarkets_user_to_organizer.organizer_id')
                ->andReturn($pdo)
            ->shouldReceive('where')
                ->once()
                ->with('fleamarkets_user_to_organizer.user_id', '=', 'foo@example.com')
                ->andReturn($pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);
        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\Organizer
         */
        $organizer = $sut->run();

        $this->assertEquals(42, $organizer->getId());
        $this->assertEquals('uuid', $organizer->getUuid());
        $this->assertEquals('Rudi Bieller', $organizer->getName());
        $this->assertEquals('Foo Street', $organizer->getStreet());
        $this->assertEquals(23, $organizer->getStreetNo());
        $this->assertEquals('Cologne', $organizer->getCity());
        $this->assertEquals(50667, $organizer->getZipCode());
        $this->assertEquals('0123456', $organizer->getPhone());
        $this->assertEquals('foo@example.com', $organizer->getEmail());
        $this->assertEquals('http://www.example.com', $organizer->getUrl());
    }
}
