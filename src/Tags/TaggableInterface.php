<?php

namespace OneMustCode\Cache\Tags;

interface TaggableInterface
{
    /**
     * @return array|Tag[]
     */
    public function getTags();

    /**
     * @param Tag $cacheTag
     * @return void
     */
    public function addTag(Tag $cacheTag);
}