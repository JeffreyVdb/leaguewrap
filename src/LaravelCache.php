<?php
namespace JeffreyVdb\LeagueWrap;

/**
 * Class LaravelCache
 *
 * @package JeffreyVdb\LeagueWrap
 */
class LaravelCache implements CacheInterface
{
    protected $cache;

    public function __construct()
    {
        $this->cache = app()->make('cache');
    }

    /**
     * Adds the response string into the cache under the given key for
     * $seconds.
     *
     * @param string $response
     * @param string $key
     * @param int    $seconds
     * @return bool
     */
    public function set($response, $key, $seconds)
    {
        return $this->cache->put($key, $response, $seconds * 60);
    }

    /**
     * Determines if the cache has the given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->cache->has($key);
    }

    /**
     * Gets the contents that are stored at the given key.
     *
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

}
