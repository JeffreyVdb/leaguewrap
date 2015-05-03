<?php
namespace JeffreyVdb\LeagueWrap\Response;

abstract class HttpClientError extends ResponseException
{
    public function getHttpStatus()
    {
        return intval(preg_replace('/.*?(\d+)$/', '$1', get_class($this)));
    }
}
