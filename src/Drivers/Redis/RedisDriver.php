<?php

namespace OneMustCode\Cache\Drivers\Redis;

use Illuminate\Cache\RedisStore;
use Illuminate\Redis\RedisManager;
use OneMustCode\Cache\Collection;
use OneMustCode\Cache\Drivers\CacheDriverException;
use OneMustCode\Cache\Drivers\CacheDriverInterface;
use OneMustCode\Cache\Item;
use OneMustCode\Cache\Tags\Tag;

class RedisDriver implements CacheDriverInterface
{
    /** @var array */
    protected $settings = [
        'driver' => 'default',
        'config' => [
        ],
    ];

    /** @var RedisStore */
    protected $redis;

    /**
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        $this->settings = array_merge($this->settings, $settings);

        $this->redis = new RedisStore(
            new RedisManager(
                $this->settings['driver'],
                $this->settings['config']
            )
        );

    }

    /**
     * @inheritdoc
     */
    public function get(Item $item)
    {
        $result = $this->redis->tags(
            $item->getTags()
        )->get(
            $item->getKey()
        );

        if (is_null($result)) {
            throw CacheDriverException::notFound();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getMultiple(Collection $collection)
    {
        $keys = $collection->getItemKeys();

        $results = $this->redis->tags(
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
        return $this->redis->tags(
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
        $this->redis->tags(
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

        $this->redis->tags(
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
        $this->redis->tags(
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
            $this->redis->flush();
        }

        $names = array_map(function (Tag $tag) {
            return $tag->getValue();
        }, $tags);

        $this->redis->tags(
            $names
        )->flush();
    }
}