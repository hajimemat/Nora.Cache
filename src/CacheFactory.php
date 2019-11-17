<?php
namespace Nora\Cache;

use Nora\Cache\Exception\InvalidCacheClass;
use Psr\SimpleCache\CacheInterface;

class CacheFactory
{
    public function __invoke($class, ...$args)
    {
        if (!class_exists($class)) {
            $class = sprintf(
                "Nora\\Cache\\Handler\\%sCache",
                ucfirst($class)
            );
        }
        if (!(new \ReflectionClass($class))->implementsInterface(CacheInterface::class)) {
            throw new InvalidCacheClass($class);
        }

        return (new \ReflectionClass($class))->newInstanceArgs($args);
    }
}

