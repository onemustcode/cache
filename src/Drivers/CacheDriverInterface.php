<?php

namespace OneMustCode\Cache\Drivers;

use OneMustCode\Cache\Collection;
use OneMustCode\Cache\Item;

interface CacheDriverInterface
{
    /**
     * Retrieve given item from the cache
     *
     * @param Item $item
     * @return Item
     * @throws CacheDriverException
     */
    public function get(Item $item);

    /**
     * Retrieve multiple items from the given collection
     *
     * @param Collection $collection
     * @return Collection
     */
    public function getMultiple(Collection $collection);

    /**
     * Checks if the given item exists in the cache
     *
     * @param Item $item
     * @return bool
     */
    public function has(Item $item);

    /**
     * Store's the given item in the cache
     *
     * @param Item $item
     * @return void
     */
    public function store(Item $item);

    /**
     * Store's multiple items in the cache via the collection
     *
     * @param Collection $collection
     * @return void
     */
    public function storeMultiple(Collection $collection);

    /**
     * Delete's the given item from the cache
     *
     * @param Item $item
     * @return void
     */
    public function delete(Item $item);

    /**
     * Flushes the entire cache of only the given tags
     *
     * @param array $tags
     * @return void
     */
    public function flush(array $tags = []);
}