<?php

namespace OneMustCode\Cache;

use OneMustCode\Cache\Drivers\CacheDriverException;
use OneMustCode\Cache\Drivers\CacheDriverInterface;

class Cache
{
    /** @var CacheDriverInterface */
    protected $driver;

    /**
     * @param CacheDriverInterface $driver
     */
    public function __construct(CacheDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Retrieves the given item from the cache
     *
     * @param Item $item
     * @param null $default
     * @return mixed
     */
    public function get(Item $item, $default = null)
    {
        try {
            return $this->driver->get($item);
        } catch (CacheDriverException $e) {
            return $default;
        }
    }

    /**
     * Retrieve multiple cache objects
     *
     * @param Collection $cacheCollection
     * @return Collection
     */
    public function getMultiple(Collection $cacheCollection)
    {
        return $this->driver->getMultiple($cacheCollection);
    }

    /**
     * Checks if the given cache objects exists
     *
     * @param Item $cacheObject
     * @return bool
     */
    public function has(Item $cacheObject)
    {
        return $this->driver->has($cacheObject);
    }

    /**
     * Store's the given cache object
     *
     * @param Item $cacheObject
     * @return void
     */
    public function store(Item $cacheObject)
    {
        $this->driver->store($cacheObject);
    }

    /**
     * Store's multiple cache objects
     *
     * @param Collection $cacheCollection
     * @return void
     */
    public function storeMultiple(Collection $cacheCollection)
    {
        $this->driver->storeMultiple($cacheCollection);
    }

    /**
     * Delete's the given cache object
     *
     * @param Item $cacheObject
     * @return void
     */
    public function delete(Item $cacheObject)
    {
        $this->driver->delete($cacheObject);
    }

    /**
     * Flushes the entire cache of only the given tags
     *
     * @param array $tags
     * @return void
     */
    public function flush(array $tags = [])
    {
        $this->driver->flush($tags);
    }
}