<?php

namespace RudiBieller\OnkelRudi\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new Config('settings.yml.dist');
    }

    public function testConfigReturnsParsedConfiguration()
    {
        $result = $this->_sut->getConfiguration();

        $this->assertArrayHasKey('Database', $result);
        $this->assertArrayHasKey('System', $result);
    }

    public function testConfigReturnsParsedDatabaseConfiguration()
    {
        $result = $this->_sut->getDatabaseConfiguration();

        $this->assertArrayHasKey('dsn', $result);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('password', $result);
    }

    public function testConfigReturnsParsedSystemConfiguration()
    {
        $result = $this->_sut->getSystemConfiguration();

        $this->assertArrayHasKey('environment', $result);
    }
}
