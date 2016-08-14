<?php

namespace RudiBieller\OnkelRudi\Cache;

use Illuminate\Cache\Repository;

class IlluminateAdapter implements CacheAdapterInterface
{
    /**
     * @var \Illuminate\Cache\Repository
     */
    private $_cacheStore;

    public function getCacheStore()
    {
        return $this->_cacheStore;
    }

    public function setCacheStore(Repository $cacheStore)
    {
        $this->_cacheStore = $cacheStore;
        return $this;
    }

    public function set($key, $value, $ttl)
    {
        $ttlInMinutes = round($ttl/60, 0);

        $this->_cacheStore->put($key, $value, $ttlInMinutes);
    }

    public function get($key)
    {
        return $this->_cacheStore->get($key);
    }

    public function delete($key)
    {
        $this->_cacheStore->forget($key);
    }

    public function clear()
    {
        $this->_cacheStore->getStore()->flush();
    }
}
