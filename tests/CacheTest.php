<?php

use Mockery as m;

class CacheTest extends PHPUnit_Framework_TestCase {

	protected $cache;
	protected $client;

	public function setUp()
	{
		$this->cache  = m::mock('JeffreyVdb\LeagueWrap\CacheInterface');
		$this->client = m::mock('JeffreyVdb\LeagueWrap\Client');
	}

	public function tearDown()
	{
		m::close();
	}

	public function testRememberChampion()
	{
		$champions = file_get_contents('tests/Json/champion.free.json');
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with($champions, '4be3fe5c15c888d40a1793190d77166b', 60)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('4be3fe5c15c888d40a1793190d77166b')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('4be3fe5c15c888d40a1793190d77166b')
		            ->andReturn($champions);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn($champions);

		$api      = new JeffreyVdb\LeagueWrap\Api('key', $this->client);
		$champion = $api->champion()
		                ->remember(60, $this->cache);
		$champion->free();
		$champion->free();
		$this->assertEquals(1, $champion->getRequestCount());
	}

	/**
	 * @expectedException JeffreyVdb\LeagueWrap\Response\HttpClientError
	 * @expectedExceptionMessage Resource not found.
	 */
	public function testRememberChampionClientError()
	{
		$this->cache->shouldReceive('set')
		            ->once()
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('3edf33d12f4be66653c05dd30c42e32c')
		            ->andReturn(false, true);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion/10101', [
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(new JeffreyVdb\LeagueWrap\Response(file_get_contents('tests/Json/champion.json'), 404));

		$api      = new JeffreyVdb\LeagueWrap\Api('key', $this->client);
		$champion = $api->champion()
		                ->remember(60, $this->cache);
		try
		{
			$champion->championById(10101);
		}
		catch (JeffreyVdb\LeagueWrap\Response\HttpClientError $exception)
		{
			$this->cache->shouldReceive('get')
		            	->once()
		            	->with('3edf33d12f4be66653c05dd30c42e32c')
		            	->andReturn($exception);
			$champion->championById(10101);
		}
	}

	public function testRememberChampionCacheOnly()
	{
		$champions = file_get_contents('tests/Json/champion.free.json');
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('4be3fe5c15c888d40a1793190d77166b')
		            ->andReturn(true);
		$this->cache->shouldReceive('get')
		            ->twice()
		            ->with('4be3fe5c15c888d40a1793190d77166b')
		            ->andReturn($champions);

		$this->client->shouldReceive('baseUrl')
		             ->twice();

		$api = new JeffreyVdb\LeagueWrap\Api('key', $this->client);
		$api->setCacheOnly()
		    ->remember(60, $this->cache);
		$champion = $api->champion();
		$champion->free();
		$champion->free();
		$this->assertEquals(0, $champion->getRequestCount());
	}

	/**
	 * @expectedException JeffreyVdb\LeagueWrap\Exception\CacheNotFoundException
	 */
	public function testRememberSummonerCacheOnlyNoHit()
	{
		$bakasan = file_get_contents('tests/Json/summoner.bakasan.json');
		$this->cache->shouldReceive('has')
		            ->once()
		            ->with('9bd8e5b11e0ac9c0a52d5711c9057dd2')
		            ->andReturn(false);
		$this->client->shouldReceive('baseUrl')
		             ->once();

		$api = new JeffreyVdb\LeagueWrap\Api('key', $this->client);
		$api->remember(null, $this->cache)
		    ->setCacheOnly();
		$summoner = $api->summoner()->info('bakasan');
	}

	public function testRememberSummonerStaticProxy()
	{
		$bakasan = file_get_contents('tests/Json/summoner.bakasan.json');
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with($bakasan, '9bd8e5b11e0ac9c0a52d5711c9057dd2', 10)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('9bd8e5b11e0ac9c0a52d5711c9057dd2')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('9bd8e5b11e0ac9c0a52d5711c9057dd2')
		            ->andReturn($bakasan);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($bakasan);

		JeffreyVdb\LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::remember(10, $this->cache);
		Summoner::info('bakasan');
		Summoner::info('bakasan');
		$this->assertEquals(1, Summoner::getRequestCount());
	}
}
