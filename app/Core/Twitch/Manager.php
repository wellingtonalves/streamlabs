<?php

namespace App\Core\Twitch;

use App\Core\Contracts\Twitch\Factory;
use App\Core\Twitch\Models\Streams;
use App\Exceptions\TwitchDriverNotFoundException;
use App\Exceptions\TwitchTypeNotFoundException;

class Manager implements Factory
{

    /**
     * @var Database|Arrayable
     */
    private $driver;


    /**
     * @param $driver
     */
    private function __construct($driver)
    {
        $this->driver = $driver;
    }

    /**
     * Gets the streams
     * @param string $type
     * @return Manager
     * @throws \Exception
     */
    static function driver(string $type = 'database'): Manager
    {
        self::isValidType($type);

        $driver = $type == 'database' ? new Database() : new Arrayable();
        return new static($driver);
    }

    /**
     * Check if type exists
     * @param string $type
     * @return void
     * @throws TwitchTypeNotFoundException
     */
    private static function isValidType(string $type): void
    {
        if (!in_array($type, ['database', 'array'])) {
            throw new TwitchTypeNotFoundException("This type '${type}' is not accept!");
        }
    }

    /**
     * Gets the streams
     * @return Streams
     * @throws TwitchDriverNotFoundException
     */
    public function streams(): Streams
    {
        return new Streams($this->driver);
    }
}