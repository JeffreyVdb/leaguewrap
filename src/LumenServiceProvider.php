<?php
namespace JeffreyVdb\LeagueWrap;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class LumenServiceProvider
 *
 * @package JeffreyVdb\LeagueWrap
 */
class LumenServiceProvider extends LaravelServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->app->bind('\JeffreyVdb\LeagueWrap\Api', function () {
            return new Api(env('LW_LOL_API_KEY'), null, LaravelCache::class);
        });
    }
}