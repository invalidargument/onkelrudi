<?php

namespace RudiBieller\OnkelRudi\User;

class UserToOrganizerReadQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testReadQueryReturnsOrganizerIdForGivenUserId()
    {
        $sut = new UserToOrganizerReadQuery();
        $pdo = \Mockery::mock('\Slim\PDO\Database');

        $result = array(
            'organizer_id' => '42'
        );
        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn($result);

        $pdo
            ->shouldReceive('select')
            ->once()
            ->with(['organizer_id'])
            ->andReturn($pdo)
            ->shouldReceive('from')
            ->once()
            ->with('fleamarkets_user_to_organizer')
            ->andReturn($pdo)
            ->shouldReceive('where')
            ->once()
            ->with('user_id', '=', 'foo@example.com')
            ->andReturn($pdo)
            ->shouldReceive('execute')
            ->once()
            ->andReturn($statement);

        $sut->setPdo($pdo);

        $sut->setIdentifier('foo@example.com');

        $organizerId = $sut->run();

        $this->assertEquals('42', $organizerId);
    }
}
