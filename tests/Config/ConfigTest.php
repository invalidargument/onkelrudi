<?php

namespace RudiBieller\OnkelRudi\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigDatabaseConfiguration()
    {
        $result = Config::$database;

        $this->assertArrayHasKey('dsn', $result);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('password', $result);
    }

    public function testConfigSystemConfiguration()
    {
        $result = Config::$system;

        $this->assertArrayHasKey('environment', $result);
        $this->assertArrayHasKey('domain', $result);
    }

    public function testConfigWordpressConfiguration()
    {
        $result = Config::$wordpress;

        $this->assertArrayHasKey('api-documentation', $result);
        $this->assertArrayHasKey('api-base-url', $result);
        $this->assertArrayHasKey('api-get-posts', $result);
        $this->assertArrayHasKey('api-get-categories', $result);
    }
}
