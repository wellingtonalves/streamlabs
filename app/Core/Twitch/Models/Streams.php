<?php

namespace App\Core\Twitch\Models;

use App\Core\Twitch\Model;
use App\Models\Stream;

class Streams extends Model
{
    /**
     * @var Model $model
     * */
    public $model = Stream::class;

}
