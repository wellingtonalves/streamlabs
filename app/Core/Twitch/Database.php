<?php

namespace App\Core\Twitch;

use App\Core\Contracts\Twitch\Driver;
use App\Core\Contracts\Twitch\Repository;
use App\Core\Twitch\Traits\CacheTrait;
use App\Core\Twitch\Traits\ModelAttributesTrait;
use Illuminate\Support\Facades\Cache;

class Database implements Driver, Repository
{
    use ModelAttributesTrait, CacheTrait;

    /**
     * Get all items
     * @param string $orderBy
     * @return mixed
     */
    public function get(string $orderBy = '')
    {
        if ($this->checkCache()) {
            return Cache::get($this->identifier);
        }

        $data = $this->model->get();

        return $this->sort($data, $orderBy);
    }

    /**
     * Get top items
     * @param int $total
     * @return Repository
     */
    public function top(int $total = 0): Repository
    {
        if ($this->checkCache()) {
            return $this;
        }

        $this->model = !$total ? $this->model : $this->model->limit($total)
            ->orderBy('viewer_count', 'DESC');

        return $this;
    }


    /**
     * Filter items per Game
     * @return object
     */
    public function median(): object
    {
        if ($this->checkCache()) {
            return $this;
        }

        return $this->model
            ->selectRaw('(SUM(viewer_count) / COUNT(viewer_count)) as media')
            ->first();
    }

    /**
     * Filter by the highest items
     * @return Repository
     */
    public function highest(): Repository
    {
        if ($this->checkCache()) {
            return $this;
        }

        $this->model = $this->model->select('game_id')
            ->selectRaw('SUM(viewer_count) as viewer_count, game_name')
            ->groupBy('game_id', 'game_name');

        return $this;
    }

    /**
     * Filter by the odd items
     * @return Repository
     */
    public function odd(): Repository
    {
        if ($this->checkCache()) {
            return $this;
        }

        $this->model = $this->model->whereRaw('mod(viewer_count,2)=1');
        return $this;
    }

    /**
     * Filter by the even items
     * @return Repository
     */
    public function even(): Repository
    {
        if ($this->checkCache()) {
            return $this;
        }

        $this->model = $this->model->whereRaw('mod(viewer_count,2)=0');
        return $this;
    }

    /**
     * Filter by the same items
     * @return Repository
     */
    public function same(): Repository
    {
        if ($this->checkCache()) {
            return $this;
        }

        $this->model = $this->model->whereIn('viewer_count', function ($query) {
            $query->select(['viewer_count'])
                ->from('streams')
                ->groupBy('viewer_count')
                ->havingRaw('COUNT(viewer_count) > 1');
        });

        return $this;
    }

    /**
     * Filter by game
     * @return Repository
     */
    public function amountByGame(): Repository
    {
        if ($this->checkCache()) {
            return $this;
        }

        $this->model = $this->model->select(['game_id', 'game_name'])
            ->selectRaw('COUNT(viewer_count) as total_amount')
            ->where('game_id', '!=', 0)
            ->groupBy('game_id', 'game_name');

        return $this;
    }

    /**
     * @param $data
     * @param $column
     * @return mixed
     */
    private function sort($data, $column)
    {
        $sort = request()->get('sort') ?? 'DESC';
        $result = $sort == 'asc' ? $data->sortBy($column)->paginate(15)
            : $data->sortByDesc($column)->paginate(15);

        return $this->cache($result, $this->identifier);
    }
}
