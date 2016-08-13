<?php

namespace RudiBieller\OnkelRudi\Cache;

use Illuminate\Cache\FileStore;
use Illuminate\Cache\Repository;
use Illuminate\Filesystem\Filesystem;

class CacheStoreFactory
{
    public function createFileStore()
    {
        $filestore = new FileStore(
            new Filesystem(),
            '/var/www/html/cache/'
        );

        //$cache = new Repository($filestore);
        //$cache->put('test', 'stay boy', 5);
        //dd($cache->get('test'));

        return new Repository($filestore);
    }
}
