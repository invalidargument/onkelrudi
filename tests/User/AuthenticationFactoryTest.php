<?php

namespace RudiBieller\OnkelRudi\User;

use Zend\Authentication\Storage\Session;

class AuthenticationFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderTestFactoryCreatesServiceWithResolvedDependencies
     */
    public function testFactoryCreatesServiceWithResolvedDependencies($user)
    {
        $factory = new AuthenticationFactory();

        $dbAdapter = new DbAuthenticationAdapter();
        $sessionStorage = new Session();
        $result = $factory->createAuthService($dbAdapter, $sessionStorage);

        $this->assertInstanceOf(
            'Zend\Authentication\AuthenticationServiceInterface',
            $result
        );

        $this->assertSame($dbAdapter, $result->getAdapter());
    }

    public function dataProviderTestFactoryCreatesServiceWithResolvedDependencies()
    {
        return array(
            array(null),
            array(new User()),
            array(new User('foo', 'foo@example.com'))
        );
    }
}
