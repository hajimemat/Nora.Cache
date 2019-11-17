<?php
namespace Nora\Cache\Handler;

use Nora\Cache\Exception\InvalidCacheClass;
use Nora\Cache\Exception\InvalidDirectory;

class FileCache extends \Nora\Cache\Cache
{
    private $cache;
    private $cacheDir;

    public function __construct(string $dir)
    {
        if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new InvalidDirectory(
                "directory [{$dir}] is not exists"
            );
        }
        if (!is_writable($dir)) {
            throw new InvalidDirectory(
                "directory [{$dir}] is not writable"
            );
        }

        $this->cacheDir = $dir;
    }

    private function keyToPath($key)
    {
        return $this->cacheDir . "/" . $key . ".cache";
    }

    public function get($key, $default = null)
    {
        $path = $this->keyToPath($key);
        if (!file_exists($path)) {
            return $dafault;
        }
        $data = unserialize(file_get_contents($path));
        if ($data['expires'] < time()) { // 有効期限切れ
            return $default;
        }

        return $data['value'];
    }

    public function set($key, $value, $ttl = null)
    {
        $path = $this->keyToPath($key);
        file_put_contents($path, serialize([
            'expires' => time()+$ttl,
            'value' => $value
        ]));
    }

    public function has($key)
    {
        $path = $this->keyToPath($key);
        if (!file_exists($path)) {
            return false;
        }
        $data = unserialize(file_get_contents($path));
        if ($data['expires'] < time()) { // 有効期限切れ
            return false;
        }

        return true;
    }

    public function delete($key)
    {
        if ($this->has($key)) {
            $path = $this->keyToPath($key);
            unlink($path);
        }
    }

    public function clear()
    {
        $dir = dir($this->cacheDir);
        while ($entry = $dir->read()) {
            if ($entry{0} == ".") {
                continue;
            } 
            unlink($this->cacheDir .'/'. $entry);
        }
    }
}
