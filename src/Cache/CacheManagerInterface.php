<?php

namespace RudiBieller\OnkelRudi\Cache;

interface CacheManagerInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl In seconds
     * @return mixed
     */
    public function set($key, $value, $ttl);
    public function get($key);
    public function delete($key);
    public function clear();
}
