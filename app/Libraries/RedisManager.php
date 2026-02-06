<?php

namespace App\Libraries;

use Config\Services;

class RedisManager
{
  protected $cache;

  public function __construct()
  {
    $this->cache = Services::cache();
    // $cache = service('cache');
    // var_dump(get_class($cache));
    // exit;
  }

  protected function buildKey(string $namespace, string $key): string
  {
    $versionKey = $namespace . '_version';
    $version = $this->cache->get($versionKey) ?? 1;

    return $namespace . '_v' . $version . '_' . $key;
  }

  public function set(string $namespace, string $key, mixed $value, int $ttl = 3600): bool
  {
    $cacheKey = $this->buildKey($namespace, $key);
    return $this->cache->save($cacheKey, $value, $ttl);
  }

  public function get(string $namespace, string $key): mixed
  {
    $cacheKey = $this->buildKey($namespace, $key);
    return $this->cache->get($cacheKey);
  }

  public function delete(string $namespace, string $key): bool
  {
    $cacheKey = $this->buildKey($namespace, $key);
    return $this->cache->delete($cacheKey);
  }

  public function exists(string $namespace, string $key): bool
  {
    return $this->get($namespace, $key) !== null;
  }

  public function clearNamespace(string $namespace): void
  {
    $versionKey = $namespace . '_version';
    $version = $this->cache->get($versionKey) ?? 1;

    $this->cache->save($versionKey, $version + 1);
  }

  public function flushAll(): bool
  {
    return $this->cache->clean();
  }
}
