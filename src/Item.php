<?php

namespace OneMustCode\Cache;

use OneMustCode\Cache\Tags\Taggable;
use OneMustCode\Cache\Tags\TaggableInterface;

class Item implements TaggableInterface
{
    use Taggable;

    /** @var string */
    protected $key;

    /** @var mixed */
    protected $data = null;

    /** @var int */
    protected $ttl = 60;

    /**
     * @param $key
     * @param null $data
     */
    public function __construct($key, $data = null)
    {
        $this->key = $key;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param $ttl
     * @return $this
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }
}
