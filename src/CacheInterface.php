<?php
namespace JeffreyVdb\LeagueWrap;

interface CacheInterface {

	/**
	 * Adds the response string into the cache under the given key for
	 * $seconds.
	 *
	 * @param string $response
     * @param string $key
	 * @param int $seconds
	 * @return bool
	 */
	public function set($response, $key, $seconds);

	/**
	 * Determines if the cache has the given key.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has($key);

	/**
	 * Gets the contents that are stored at the given key.
	 *
	 * @param string $key
	 * @return string
	 */
	public function get($key);
}
