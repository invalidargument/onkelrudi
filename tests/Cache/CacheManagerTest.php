<?php

namespace RudiBieller\OnkelRudi\Cache;

class CacheManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheManager
     */
    private $_sut;
    /**
     * @var CacheAdapterInterface
     */
    private $_cacheAdapter;

    protected function setUp()
    {
        parent::setUp();
        $this->_sut = new CacheManager();
        $this->_cacheAdapter = \Mockery::mock('RudiBieller\OnkelRudi\Cache\CacheAdapterInterface');
        $this->_sut->setAdapter($this->_cacheAdapter);
    }

    public function testSettingOfValuesToCache()
    {
        $cacheKey = 'my-key';
        $cacheValue = 'my-value';
        $ttl = 'my-key';

        $this->_cacheAdapter->shouldReceive('set')
            ->once()
            ->with($cacheKey, $cacheValue, $ttl);

        $this->_sut->set($cacheKey, $cacheValue, $ttl);
    }

    public function testGettingOfValuesFromCache()
    {
        $cacheKey = 'my-key';

        $this->_cacheAdapter->shouldReceive('get')
            ->once()
            ->with($cacheKey);

        $this->_sut->get($cacheKey);
    }

    public function testDeletingOfValuesFromCache()
    {
        $cacheKey = 'my-key';

        $this->_cacheAdapter->shouldReceive('delete')
            ->once()
            ->with($cacheKey);

        $this->_sut->delete($cacheKey);
    }
}
