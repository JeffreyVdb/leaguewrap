<?php
namespace LeagueWrap\Api;

use LeagueWrap\Response\Summoner;

abstract class Api {
	
	/**
	 * The client used to communicate with the api
	 *
	 * @var object
	 */
	protected $client;

	/**
	 * The key to be used by the api.
	 *
	 * @param string
	 */
	protected $key;

	/**
	 * The region to be used by the api.
	 *
	 * @param string
	 */
	protected $region;

	/**
	 * The version we want to use. If null use the first
	 * version in the array.
	 *
	 * @param string|null
	 */
	protected $version = null;

	/**
	 * A count of the amount of API request this object has done
	 * so far.
	 *
	 * @param int
	 */
	protected $requests = 0;

	/**
	 * Returns the amount of requests this object has done
	 * to the api so far.
	 *
	 * @return int
	 */
	public function getRequestCount()
	{
		return $this->requests;
	}

	/**
	 * Set the key to be used in the api.
	 *
	 * @param string $key
	 * @chainable
	 */
	public function setKey($key)
	{
		$this->key = $key;
		return $this;
	}

	/**
	 * Set the region to be used in the api.
	 *
	 * @param string $region
	 * @chainable
	 */
	public function setRegion($region)
	{
		$this->region = $region;
		return $this;
	}

	/**
	 * Select the version of the api you wish to
	 * query.
	 *
	 * @param string $version
	 * @return bool|$this
	 * @chainable
	 */
	public function selectVersion($version)
	{
		if ( ! in_array($version, $this->versions))
		{
			// not a value version
			return false;
		}

		$this->version = $version;
		return $this;
	}

	/**
	 * Wraps the request of the api in this method.
	 *
	 * @param string $path
	 * @param array $params
	 * @return array
	 */
	protected function Request($path, $params = [])
	{
		// get version
		$version = $this->getVersion();
		// set up the uri
		$params['api_key'] = $this->key;
		$uri      = $this->region.'/'.$version.'/'.$path.'?'.http_build_query($params);
		$response = $this->client
		                 ->get($uri)
		                 ->send();

		// request was succesful
		++$this->requests;

		$body = $response->getBody();
		$body->seek(0);
		$content = $body->read($body->getSize());

		// decode the content
		return json_decode($content, true);
	}

	/**
	 * Get the version string.
	 *
	 * @return string
	 */
	protected function getVersion()
	{
		if (is_null($this->version))
		{
			// get the first version in versions
			$this->version = reset($this->versions);
		}
		
		return $this->version;
	}

	/**
	 * Attempts to extract an ID from the object/value given
	 *
	 * @param mixed $identity
	 * @return int
	 * @throws Exception
	 */
	protected function extractId($identity)
	{
		if ($identity instanceof Summoner)
		{
			return $identity->id;
		}
		elseif (is_int($identity))
		{
			return $identity;
		}
		else
		{
			throw new Exception('The identity given was not valid.');
		}
	}

	/**
	 * Attempts to attach the response to a summoner object.
	 *
	 * @param mixed $identity
	 * @param mixed $response
	 * @param string $key
	 * @return bool
	 */
	protected function attachResponse($identity, $response, $key)
	{
		if ($identity instanceof Summoner)
		{
			$identity->set($key, $response);
			return true;
		}
		
		return false;
	}
}
