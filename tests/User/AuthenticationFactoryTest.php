<?php

namespace RudiBieller\OnkelRudi\User;

use Zend\Authentication\Storage\Session;

class AuthenticationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryCreatesServiceWithResolvedDependencies()
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
}
