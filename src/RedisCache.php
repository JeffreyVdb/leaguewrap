<?php
namespace JeffreyVdb\LeagueWrap;

/**
 * Class RedisCache
 *
 * @package JeffreyVdb\LeagueWrap
 */
class RedisCache implements CacheInterface
{
    protected $cache;

    public function __construct()
    {
        $this->cache = new Predis\Client;
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
        return $this->cache->set($key, $response, $seconds);
    }

    /**
     * Determines if the cache has the given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->cache->exists($key);
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
