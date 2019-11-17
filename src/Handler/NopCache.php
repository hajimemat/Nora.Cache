<?php
namespace Nora\Cache\Handler;

use Nora\Cache\Exception\InvalidCacheClass;

class NopCache extends \Nora\Cache\Cache
{
    public function get($key, $default = null)
    {
    }

    public function set($key, $value, $ttl = null)
    {
    }

    public function has($key)
    {
        return false;
    }

    public function delete($key)
    {
    }

    public function clear()
    {
    }
}
