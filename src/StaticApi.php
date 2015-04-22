<?php
namespace JeffreyVdb\LeagueWrap;

final class StaticApi {

	/**
	 * A list of all known static proxies to be found.
	 *
	 * @var array
	 */
	protected static $staticProxy = [
		'Api',
		'Champion',
		'Game',
		'League',
		'Stats',
		'Summoner',
		'Team',
		'StaticData',
	];

	/**
	 * Mount all the static static proxys found in the StaticProxy directory.
	 *
	 * @return void
	 */
	public static function mount()
	{
		foreach (self::$staticProxy as $staticProxy)
		{
			$staticProxyObject = '\\JeffreyVdb\\LeagueWrap\\StaticProxy\\Static'.$staticProxy;
			// mount it
			$staticProxyObject::mount();
			// freshen it up
			$staticProxyObject::fresh();
		}
	}
}
