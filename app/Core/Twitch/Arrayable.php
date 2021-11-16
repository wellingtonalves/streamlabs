<?php

namespace App\Core\Twitch;

use App\Core\Contracts\Twitch\Driver;
use App\Core\Contracts\Twitch\Repository;
use App\Core\Twitch\Traits\CacheTrait;
use App\Core\Twitch\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class Arrayable implements Repository, Driver
{
    use ModelAttributesTrait, CacheTrait;

    /**
     * Get all items
     * @param string $orderBy
     * @return false|string
     */
    public function get(string $orderBy = '')
    {
        if ($this->checkCache()) {
            return Cache::get($this->identifier);
        }

        return $this->sort(new Collection($this->model), $orderBy);
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

        $result = [];

        $count = $this->model->count();
        for ($outer = 0; $outer < $count; $outer++) {
            for ($inner = 0; $inner < $count; $inner++) {
                if ($this->model[$outer]->viewer_count > $this->model[$inner]->viewer_count) {
                    $tmp = $this->model[$outer];
                    $this->model[$outer] = $this->model[$inner];
                    $this->model[$inner] = $tmp;
                }
            }
        }


        for ($i = 0; $i < 100; $i++) {
            $result[] = $this->model[$i];
        }
        $this->model = $result;

        return $this;
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

        $result = [];
        foreach ($this->model as $value) {
            $addItem = true;
            for ($i = 0; $i < count($result); $i++) {
                if ($result[$i]['game_id'] == $value->game_id) {
                    $result[$i]['viewer_count'] += $value->viewer_count;
                    $addItem = false;
                    break;
                }
            }

            if ($addItem) {
                $result[] = [
                    'game_id' => $value->game_id,
                    'viewer_count' => $value->viewer_count,
                    'game_name' => $value->game_name,
                ];
            }

            if (empty($result)) {
                $result[] = [
                    'game_id' => $value->game_id,
                    'viewer_count' => $value->viewer_count,
                    'game_name' => $value->game_name,
                ];
            }
        }

        $this->model = $result;
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

        $result = [];

        foreach ($this->model as $item) {
            if ($item->viewer_count % 2 == 1) {
                $result[] = $item;
            }
        }
        $this->model = $result;
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

        $result = [];

        foreach ($this->model as $item) {
            if ($item->viewer_count % 2 == 0) {
                $result[] = $item;
            }
        }
        $this->model = $result;
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

        $result = [];

        foreach ($this->model as $key => $value) {
            $temp = [];
            foreach ($this->model as $subKey => $subValue) {
                if ($subValue->viewer_count == $value->viewer_count && $subValue->id != $value->id) {
                    if (empty($temp)) {
                        $temp[] = $value;
                    }
                    $temp[] = $subValue;
                }
            }

            foreach ($temp as $item) {
                $result[$item->id] = $item;
            }
        }

        $this->model = $result;

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

        $totalLives = $this->model->count();
        $amount = 0;
        foreach ($this->model as $item) {
            $amount += $item->viewer_count;
        }

        return new Collection(['media' => $amount / $totalLives]);
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

        $result = [];
        foreach ($this->model as $value) {
            $addItem = true;
            for ($i = 0; $i < count($result); $i++) {
                if ($result[$i]['game_id'] == $value->game_id || $value->game_id === 0) {
                    $result[$i]['total_amount'] += 1;
                    $addItem = false;
                    break;
                }
            }

            if ($addItem) {
                $result[] = [
                    'game_id' => $value->game_id,
                    'game_name' => $value->game_name,
                    'total_amount' => 1,
                ];
            }

            if (empty($result)) {
                $result[] = [
                    'game_id' => $value->game_id,
                    'game_name' => $value->game_name,
                    'total_amount' => 1,
                ];
            }
        }

        $this->model = $result;
        return $this;
    }

    /**
     * @param $data
     * @param $column
     * @return false|string
     */
    private function sort($data, $column)
    {
        $sort = request()->get('sort') ?? 'DESC';
        $result = $sort == 'asc' ? $data->sortBy($column)->paginate(15)
            : $data->sortByDesc($column)->paginate(15);

        return $this->cache($result, $this->identifier);
    }
}
