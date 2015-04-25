<?php
namespace JeffreyVdb\LeagueWrap\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * Class Api
 *
 * @package JeffreyVdb\LeagueWrap\Facades
 */
class Api extends Facade
{
    protected static function getFacadeAccessor()
    {
        return '\JeffreyVdb\LeagueWrap\Api';
    }
}
