<?php

namespace RudiBieller\OnkelRudi\Cache;

use RudiBieller\OnkelRudi\Config\Config;

class CacheManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryCreatesManagerWithIlluminateAsDefault()
    {
        $factory = new CacheManagerFactory();
        $manager = $factory->createCacheManager(new Config('settings_test.yml'));

        $this->assertInstanceOf('RudiBieller\OnkelRudi\Cache\CacheManager', $manager);
        $this->assertInstanceOf('RudiBieller\OnkelRudi\Cache\CacheAdapterInterface', $manager->getAdapter());
    }
}
