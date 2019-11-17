<?php
namespace Nora\Cache;

use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testCache()
    {
        $cache = (new CacheFactory)("nop");
        $cache = (new CacheFactory)("array");

        $cache->set('a', 'aaaaa');

        $this->assertSame('aaaaa', $cache->get('a'));
    }

    public function testFileCache()
    {
        $cache = (new CacheFactory)("file", __DIR__ . "/cache");

        $cache->set('hoge', 'fuga');

        $this->assertTrue($cache->has('hoge'));
        $this->assertSame("fuga", $cache->get('hoge'));
        $cache->clear();
        $this->assertFalse($cache->has('hoge'));
    }
}
