<?php

namespace RudiBieller\OnkelRudi\Cache;

use Illuminate\Cache\FileStore;
use Illuminate\Cache\Repository;
use Illuminate\Filesystem\Filesystem;

class CacheManagerFactory
{
    const ADAPTER_TYPE_ILLUMINATE = 'Illuminate'; // retrieve from Config?!

    public function createCacheManager($adapterName = self::ADAPTER_TYPE_ILLUMINATE)
    {
        $adapterClass = 'RudiBieller\OnkelRudi\Cache\\' . $adapterName . 'Adapter';

        $manager = new CacheManager();
        $adapter = new $adapterClass();
        $repository = new Repository(
            new FileStore(
                new Filesystem(),
                '/var/www/html/cache/'
            )
        );
        $adapter->setCacheStore($repository);
        $manager->setAdapter($adapter);

        return $manager;
    }
}
