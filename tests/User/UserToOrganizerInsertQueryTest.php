<?php

namespace RudiBieller\OnkelRudi\User;

class UserToOrganizerInsertQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testInsertQueryStoresUserToOrganizerMap()
    {
        $sut = new UserToOrganizerInsertQuery();
        $pdo = \Mockery::mock('\Slim\PDO\Database');
        $pdo
            ->shouldReceive('insert')
                ->once()
                ->with(array('user_id', 'organizer_id'))
                ->andReturn($pdo)
            ->shouldReceive('into')
                ->once()
                ->with('fleamarkets_user_to_organizer')
                ->andReturn($pdo)
            ->shouldReceive('values')
                ->once()
                ->with(array('foo@example.com', 23))
                ->andReturn($pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn(1);

        $sut->setPdo($pdo);
        
        $sut->setUserId('foo@example.com')->setOrganizerId(23);

        $sut->run();
    }
}
