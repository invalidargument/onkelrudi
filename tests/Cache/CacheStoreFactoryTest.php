<?php

namespace RudiBieller\OnkelRudi\Cache;

class CacheStoreFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAdapterCreatesIlluminateFileStore()
    {
        $factory = new CacheStoreFactory();
        $store = $factory->createFileStore();

        $this->assertInstanceOf('Illuminate\Cache\Repository', $store);
    }
}
