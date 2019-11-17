<?php
namespace Nora\Cache\Handler;

use Nora\Cache\Exception\InvalidCacheClass;

class ArrayCache extends \Nora\Cache\Cache
{
    private $cache;

    public function get($key, $default = null)
    {
        return $this->cache[$key] ?? $default;
    }

    public function set($key, $value, $ttl = null)
    {
        $this->cache[$key] = $value;
    }

    public function has($key)
    {
        return isset($this->cache[$key]);
    }

    public function delete($key)
    {
        unset($this->cache[$key]);
    }

    public function clear()
    {
        $this->cache = null;
    }
}
