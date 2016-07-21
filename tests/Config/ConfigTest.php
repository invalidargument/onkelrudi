<?php

namespace RudiBieller\OnkelRudi\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigParsesGivenConfiguration()
    {
        $fixture = new Config('settings_test.yml');

        $this->assertSame('test', $fixture->getDatabaseConfiguration()['user']);
        $this->assertSame('test', $fixture->getSystemConfiguration()['environment']);
        $this->assertSame('test', $fixture->getWordpressConfiguration()['auth-username']);
        $this->assertSame('test', $fixture->getMailConfiguration()['smtp-host']);
    }
}
