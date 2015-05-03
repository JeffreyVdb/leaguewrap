<?php
namespace JeffreyVdb\LeagueWrap;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Predis\Client;

/**
 * Class LumenServiceProvider
 *
 * @package JeffreyVdb\LeagueWrap
 */
class LumenServiceProvider extends LaravelServiceProvider
{
    protected $defer = false;

    private function getPreferredCache()
    {
        switch (env('CACHE_DRIVER')) {
            case 'memcached':
                return Cache::class;

            case 'redis':
            default:
                return function () {
                    $server = env('LW_REDIS_HOST', '127.0.0.1');
                    $port = env('LW_REDIS_PORT', '6379');

                    return new RedisCache([
                        'scheme' => 'tcp',
                        'host'   => $server,
                        'port'   => $port
                    ]);
                };
        }
    }

    public function register()
    {
        // Figure out which cache to use
        $cacheClass = $this->getPreferredCache();

        $this->app->bind('\JeffreyVdb\LeagueWrap\Api', function () use ($cacheClass) {
            return new Api(env('LW_LOL_API_KEY'), null, $cacheClass);
        });
    }
}