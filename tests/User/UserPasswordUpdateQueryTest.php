<?php

namespace RudiBieller\OnkelRudi\User;

class UserPasswordUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryUpdatesUserWithGivenIdentifier()
    {
        $sut = new UserPasswordUpdateQuery();
        $pdo = \Mockery::mock('\Slim\PDO\Database');
        $sut->setPdo($pdo);
        
        $pdo->shouldReceive('update')->once()->with(array('password' => 'pwd'))->andReturn($pdo);
        $pdo->shouldReceive('table')->once()->with('fleamarkets_users')->andReturn($pdo);
        $pdo->shouldReceive('where')->once()->with('email', '=', 'info@onkel-rudi.de')->andReturn($pdo);
        $pdo->shouldReceive('execute')->once()->andReturn(1);

        $sut->setIdentifier('info@onkel-rudi.de')->setPassword('pwd');
        $result = $sut->run();

        $this->assertSame(1, $result);
    }
}
