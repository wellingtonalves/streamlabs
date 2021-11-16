<?php

namespace App\Core\Twitch;

use App\Core\Contracts\Twitch\Driver;
use App\Core\Contracts\Twitch\Repository;
use App\Core\Twitch\Traits\DriversTrait;
use App\Core\Twitch\Traits\ModelAttributesTrait;
use App\Exceptions\TwitchDriverNotFoundException;

class Model implements Repository
{
    use DriversTrait, ModelAttributesTrait;

    /**
     * @param Driver $driver
     * @throws TwitchDriverNotFoundException
     */
    public function __construct(Driver $driver)
    {
        $this->setDriver($driver);
        return $this;
    }

    /**
     * @param $driver
     * @throws TwitchDriverNotFoundException
     */
    function setDriver($driver)
    {
        $class = get_class($driver);

        switch ($class) {
            case Database::class:
                $this->database();
                break;
            case Arrayable::class:
                $this->arrayable();
                break;
            default:
                throw new TwitchDriverNotFoundException("Driver '${class}' not found!");
        }
    }

    /**
     * Get all items
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function get(string $orderBy = '', string $sort = 'DESC')
    {
        return $this->driver->get($orderBy, $sort);
    }

    /**
     * Get top items
     * @param int $total
     * @return Repository
     */
    public function top(int $total = 0): Repository
    {
        return $this->driver->top($total);
    }

    /**
     * Filter items per median
     * @return object
     */
    public function median(): object
    {
        return $this->driver->median();
    }

    /**
     * Filter by the highest items
     * @return Repository
     */
    public function highest(): Repository
    {
        return $this->driver->highest();
    }

    /**
     * Filter by the odd items
     * @return Repository
     */
    public function odd(): Repository
    {
        return $this->driver->odd();
    }

    /**
     * Filter by the even items
     * @return Repository
     */
    public function even(): Repository
    {
        return $this->driver->even();
    }

    /**
     * Filter by the same items
     * @return Repository
     */
    public function same(): Repository
    {
        return $this->driver->same();
    }

    /**
     * Filter by game
     * @return Repository
     */
    public function amountByGame(): Repository
    {
        return $this->driver->amountByGame();
    }
}