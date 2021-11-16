<?php

namespace App\Core\Twitch\Traits;

use App\Core\Contracts\Twitch\Repository;
use App\Core\Twitch\Arrayable;
use App\Core\Twitch\Database;
use Illuminate\Support\Facades\Cache;

trait DriversTrait
{
    /**
     * @var $driver Repository
     * */
    protected $driver;

    /**
     */
    private function database()
    {
        $this->driver = new Database();
        $this->driver->model = $this->model::query();
        $this->driver->identifier = request()->fullUrl();
    }

    /**
     */
    private function arrayable()
    {
        $this->driver = new Arrayable();
        $this->driver->identifier = request()->fullUrl();
        $identifier = 'streams';

        if (env('CACHE_ENABLED')) {
            if (Cache::has($identifier)) {
                $this->driver->model = Cache::get($identifier);
                return true;
            }

            $this->driver->model = $this->model::query()->get();
            Cache::put($identifier, $this->driver->model);
            return true;
        }

        $this->driver->model = $this->model::query()->get();
    }
}
