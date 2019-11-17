<?php
namespace Nora\Cache;

use Psr;

abstract class Cache implements Psr\SimpleCache\CacheInterface
{
    abstract public function get($key, $default = null);
    abstract public function set($key, $value, $ttl = null);
    abstract public function has($key);
    abstract public function delete($key);
    abstract public function clear();

    public function getMultiple($keys, $default = null)
    {
        $ret = [];
        foreach ($keys as $key) {
            $ret[$key] = $this->get($key);
        }
        return $ret;
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }
}
