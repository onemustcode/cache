<?php

namespace OneMustCode\Cache;

use OneMustCode\Cache\Tags\Taggable;
use OneMustCode\Cache\Tags\TaggableInterface;

class Collection implements TaggableInterface
{
    use Taggable;

    /** @var array|Item[] */
    protected $items = [];

    /** @var null|int */
    protected $ttl;

    /**
     * @param array $items
     * @param null|int $ttl
     */
    public function __construct(array $items = [], $ttl = 60)
    {
        $this->ttl = $ttl;

        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @return array|Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        if ($this->itemExists($item) === false) {
            $this->items[] = $item;
        }
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function itemExists(Item $item)
    {
        return in_array($item, $this->items, true);
    }

    /**
     * @param Item $item
     */
    public function removeItem(Item $item)
    {
        $key = array_search($item, $this->items, true);

        if ($key === true) {
            unset($this->items[$key]);
        }
    }

    /**
     * @return array
     */
    public function getItemKeys()
    {
        return array_map(function (Item $item) {
            return $item->getKey();
        }, $this->items);
    }

    /**
     * @return int|null
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param int|null $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }
}