<?php

namespace RudiBieller\OnkelRudi\Cache;

class IlluminateAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IlluminateAdapter
     */
    private $_sut;
    private $_cacheStore;

    protected function setUp()
    {
        parent::setUp();
        $this->_sut = new IlluminateAdapter();
        $this->_cacheStore = \Mockery::mock('Illuminate\Cache\Repository');
        $this->_sut->setCacheStore($this->_cacheStore);
    }

    public function testSettingOfValuesToCache()
    {
        $cacheKey = 'my-key';
        $cacheValue = 'my-value';
        $ttl = 3600;

        $this->_cacheStore->shouldReceive('put')
            ->once()
            ->with($cacheKey, $cacheValue, 60);

        $this->_sut->set($cacheKey, $cacheValue, $ttl);
    }

    public function testGettingOfValuesFromCache()
    {
        $cacheKey = 'my-key';

        $this->_cacheStore->shouldReceive('get')
            ->once()
            ->with($cacheKey);

        $this->_sut->get($cacheKey);
    }

    public function testDeletingOfValuesFromCache()
    {
        $cacheKey = 'my-key';

        $this->_cacheStore->shouldReceive('forget')
            ->once()
            ->with($cacheKey);

        $this->_sut->delete($cacheKey);
    }

    public function testFlushingCache()
    {
        $store = \Mockery::mock('Illuminate\Cache\FileStore');
        $store->shouldReceive('flush')
            ->once();
        $this->_cacheStore->shouldReceive('getStore')
            ->once()
            ->andReturn($store);

        $this->_sut->clear();
    }
}
