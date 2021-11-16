<?php

namespace App\Core\Support;


class Helpers
{

    /**
     * Randomize an array
     * @param $array
     * @return mixed
     */
    public static function randomizeArray($array)
    {
        $total = count($array);
        while (--$total) {
            $indexRand = mt_rand(0, $total);
            if ($total != $indexRand) {
                $arrayTemp = $array[$indexRand];
                $array[$indexRand] = $array[$total];
                $array[$total] = $arrayTemp;
            }
        }

        return $array;
    }
}
