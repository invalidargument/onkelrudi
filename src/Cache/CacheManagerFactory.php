<?php

namespace RudiBieller\OnkelRudi\Cache;

class CacheManagerFactory
{
    const ADAPTER_TYPE_ILLUMINATE = 'Illuminate'; // retrieve from Config?!

    public function createCacheManager($adapterName = self::ADAPTER_TYPE_ILLUMINATE)
    {
        $adapterClass = 'RudiBieller\OnkelRudi\Cache\\' . $adapterName . 'Adapter';

        $manager = new CacheManager();
        $manager->setAdapter(new $adapterClass());

        return $manager;
    }
}
