<?php
namespace JeffreyVdb\LeagueWrap;

use Predis\Client as PredisClient;

/**
 * Class RedisCache
 *
 * @package JeffreyVdb\LeagueWrap
 */
class RedisCache implements CacheInterface
{
    protected $cache;

    public function __construct($config = null)
    {
        $this->cache = $config ? new PredisClient($config) : new PredisClient();
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
        return $this->cache->setex($key, $seconds, serialize($response));
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
        return unserialize($this->cache->get($key));
    }

}
