<?php
namespace JeffreyVdb\LeagueWrap;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package JeffreyVdb\LeagueWrap
 */
class ServiceProvider extends LaravelServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->app->bind('\JeffreyVdb\LeagueWrap\Api', function () {
            return new Api(config('leaguewrap.api_key'), null, LaravelCache::class);
        });
    }

    public function boot()
    {
        $this->handleConfiguration();
    }

    private function handleConfiguration()
    {
        $configPath = __DIR__ . '/../config/leaguewrap.php';
        $this->publishes([$configPath => config_path('leaguewrap.php')]);
        $this->mergeConfigFrom($configPath, 'leaguewrap');
    }
}
