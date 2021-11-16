<?php

namespace App\Core\Twitch\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheTrait
{

    public $identifier;

    /**
     * @param $data
     * @param $identifier
     * @return false|string
     */
    private function cache($data, $identifier)
    {
        if (!env('CACHE_ENABLED')) {
            return $data;
        }

        if (Cache::has($identifier)) {
            return Cache::get($identifier);
        }

        Cache::put($identifier, $data, 900);

        return $data;
    }

    /**
     * @return bool
     */
    public function checkCache(): bool
    {
        return env('CACHE_ENABLED') && Cache::has($this->identifier);
    }
}
