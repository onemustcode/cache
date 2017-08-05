<?php

namespace OneMustCode\Cache\Drivers;

use Exception;

class CacheDriverException extends Exception
{
    /**
     * @param string $key
     * @return CacheDriverException
     */
    public static function notFound($key)
    {
        return new self(
            sprintf('The given cache item with key [%s] is not found!', $key)
        );
    }
}