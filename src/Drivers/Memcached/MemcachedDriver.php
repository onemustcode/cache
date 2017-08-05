<?php

namespace OneMustCode\Cache\Drivers\Memcached;

use Illuminate\Cache\MemcachedConnector;
use Illuminate\Cache\MemcachedStore;
use OneMustCode\Cache\Collection;
use OneMustCode\Cache\Drivers\CacheDriverException;
use OneMustCode\Cache\Drivers\CacheDriverInterface;
use OneMustCode\Cache\Item;
use OneMustCode\Cache\Tags\Tag;

class MemcachedDriver implements CacheDriverInterface
{
    /** @var array */
    protected $settings = [
        'persistent_id' => null,
        'sals' => [],
        'options' => [],
        'servers' => [
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
        ],
        'prefix' => '',
    ];

    /** @var MemcachedStore */
    protected $memcached;

    /**
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        $this->settings = array_merge($this->settings, $settings);

        $memcachedConnected = new MemcachedConnector();

        $this->memcached = new MemcachedStore(
            $memcachedConnected->connect(
                $this->settings['servers'],
                $this->settings['persistent_id'],
                $this->settings['options'],
                $this->settings['sasl']
            ),
            $this->settings['prefix']
        );
    }

    /**
     * @inheritdoc
     */
    public function get(Item $item)
    {
        $result = $this->memcached->tags(
            $item->getTags()
        )->get(
            $item->getKey()
        );

        if (is_null($result)) {
            throw CacheDriverException::notFound($item->getKey());
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getMultiple(Collection $collection)
    {
        $keys = $collection->getItemKeys();

        $results = $this->memcached->tags(
            $collection->getTags()
        )->many(
            $keys
        );

        foreach ($collection->getItems() as $item) {
            if (isset($results[$item->getKey()])) {
                $item->setData(
                    $results[$item->getKey()]
                );
            }
        }

        return $collection;
    }

    /**
     * @inheritdoc
     */
    public function has(Item $item)
    {
        return $this->memcached->tags(
            $item->getTags()
        )->has(
            $item->getKey()
        );
    }

    /**
     * @inheritdoc
     */
    public function store(Item $item)
    {
        $this->memcached->tags(
            $item->getTags()
        )->put(
            $item->getKey(),
            $item,
            $item->getTtl()
        );
    }

    /**
     * @inheritdoc
     */
    public function storeMultiple(Collection $collection)
    {
        $values = array_map(function (Item $item) {
            return [$item->getKey(), $item];
        }, $collection->getItems());

        $this->memcached->tags(
            $collection->getTags()
        )->putMany(
            $values,
            $collection->getTtl()
        );
    }

    /**
     * @inheritdoc
     */
    public function delete(Item $item)
    {
        $this->memcached->tags(
            $item->getTags()
        )->forget(
            $item->getKey()
        );
    }

    /**
     * @inheritdoc
     */
    public function flush(array $tags = [])
    {
        if (count($tags) === 0) {
            $this->memcached->flush();
        }

        $names = array_map(function (Tag $tag) {
            return $tag->getValue();
        }, $tags);

        $this->memcached->tags(
            $names
        )->flush();
    }
}