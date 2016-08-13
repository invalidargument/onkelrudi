<?php

namespace RudiBieller\OnkelRudi\Cache;

class CacheManager implements CacheManagerInterface
{
    private $_adapter;

    public function setAdapter(CacheAdapterInterface $adapter)
    {
        $this->_adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function set($key, $value, $ttl)
    {
        $this->_adapter->set($key, $value, $ttl);
    }

    public function get($key)
    {
        $this->_adapter->get($key);
    }

    public function delete($key)
    {
        $this->_adapter->delete($key);
    }

    public function clear()
    {
        throw new \Exception('Method cannot be handled, forget about it.');
    }
}
