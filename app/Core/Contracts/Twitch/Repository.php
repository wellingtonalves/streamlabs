<?php

namespace App\Core\Contracts\Twitch;

interface Repository
{
    /**
     * Get all items
     * @param string $orderBy
     */
    public function get(string $orderBy = '');

    /**
     * Get top items
     * @param int $total
     * @return Repository
     */
    public function top(int $total = 0): Repository;


    /**
     * Filter items per Game
     * @return object
     */
    public function median(): object;

    /**
     * Filter by the highest items
     * @return Repository
     */
    public function highest(): Repository;

    /**
     * Filter by the odd items
     * @return Repository
     */
    public function odd(): Repository;

    /**
     * Filter by the even items
     * @return Repository
     */
    public function even(): Repository;

    /**
     * Filter by the same items
     * @return Repository
     */
    public function same(): Repository;

    /**
     * Filter by game
     * @return Repository
     */
    public function amountByGame(): Repository;
}
