<?php

namespace RudiBieller\OnkelRudi\User;

class AuthenticationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryCreatesServiceWithResolvedDependencies()
    {
        $factory = new AuthenticationFactory();

        $dbAdapter = new DbAuthenticationAdapter();
        $result = $factory->createAuthService($dbAdapter);

        $this->assertInstanceOf(
            'Zend\Authentication\AuthenticationServiceInterface',
            $result
        );

        $this->assertSame($dbAdapter, $result->getAdapter());
    }
}
