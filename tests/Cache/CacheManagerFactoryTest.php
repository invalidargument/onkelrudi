<?php

namespace RudiBieller\OnkelRudi\Cache;

class CacheManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryCreatesManagerWithIlluminateAsDefault()
    {
        $factory = new CacheManagerFactory();
        $manager = $factory->createCacheManager();

        $this->assertInstanceOf('RudiBieller\OnkelRudi\Cache\CacheManager', $manager);
        $this->assertInstanceOf('RudiBieller\OnkelRudi\Cache\CacheAdapterInterface', $manager->getAdapter());
    }
}
