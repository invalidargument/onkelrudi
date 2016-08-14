<?php

namespace RudiBieller\OnkelRudi\Cache;

use Illuminate\Cache\FileStore;
use Illuminate\Cache\Repository;
use Illuminate\Filesystem\Filesystem;
use RudiBieller\OnkelRudi\Config\Config;

class CacheManagerFactory
{
    public function createCacheManager(Config $config)
    {
        $adapterClass = 'RudiBieller\OnkelRudi\Cache\\' . $config->getSystemConfiguration()['cache-adapter'] . 'Adapter';

        $manager = new CacheManager();
        $adapter = new $adapterClass();
        $repository = new Repository(
            new FileStore(
                new Filesystem(),
                $config->getSystemConfiguration()['cache-path']
            )
        );
        $adapter->setCacheStore($repository);
        $manager->setAdapter($adapter);

        return $manager;
    }
}
