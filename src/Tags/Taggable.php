<?php

namespace OneMustCode\Cache\Tags;

trait Taggable
{
    /** @var array|Tag[] */
    protected $tags = [];

    /**
     * @return array|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        if (in_array($tag, $this->tags, true) === false) {
            $this->tags[] = $tag;
        }
    }
}