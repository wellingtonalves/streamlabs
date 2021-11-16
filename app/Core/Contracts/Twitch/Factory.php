<?php

namespace App\Core\Contracts\Twitch;

use App\Core\Twitch\Models\Streams;
use App\Core\Twitch\Manager;

interface Factory
{
    /**
     * Set driver
     * @param string $type
     * @return Manager
     */
    static function driver(string $type = 'database'): Manager;


    /**
     * Gets the streams
     * @return Streams
     */
    public function streams(): Streams;

}
