<?php

namespace RudiBieller\OnkelRudi\User;

use Zend\Authentication\Storage\Session;

class AuthenticationFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AuthenticationFactory
     */
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new AuthenticationFactory();
    }

    public function testFactoryCreatesServiceWithResolvedDependencies()
    {
        $dbAdapter = new DbAuthenticationAdapter();
        $sessionStorage = new Session();
        $result = $this->_sut->createAuthService($dbAdapter, $sessionStorage);

        $this->assertInstanceOf(
            'Zend\Authentication\AuthenticationServiceInterface',
            $result
        );

        $this->assertSame($dbAdapter, $result->getAdapter());
    }

    /**
     * @dataProvider dataProviderTestCreatingAnAuthAdapter
     */
    public function testCreatingAnAuthAdapter(UserInterface $user = null)
    {
        $adapter = $this->_sut->createAuthAdapter($user);
        $adapter2 = $this->_sut->createAuthAdapter($user);

        $this->assertInstanceOf('RudiBieller\OnkelRudi\User\DbAuthenticationAdapter', $adapter);
        $this->assertSame($adapter, $adapter2);
    }

    public function dataProviderTestCreatingAnAuthAdapter()
    {
        return array(
            array(null),
            array(new User('foo@example.com', 'bar'))
        );
    }

    public function testCreatingSessionStorage()
    {
        $storage = $this->_sut->createSessionStorage();
        $storage2 = $this->_sut->createSessionStorage();

        $this->assertInstanceOf('Zend\Authentication\Storage\Session', $storage);
        $this->assertSame($storage, $storage2);
    }
}
