<?php

use Carbon\Carbon;


if (! function_exists('TimeFormat')) {
    function TimeFormat($time){
        $hour = floor($time / 3600);
        $min = floor(($time - $hour * 3600) / 60);
        $sec = floor($time - $hour * 3600 - $min * 60);
        return $hour . ":" . $min . ":" . $sec;
    }
}

if (! function_exists('MakeListofIds')) {
    function MakeListofIds($list){
        $resList = [];
        foreach($list as $item)
        {
            // if (isset($item->music_id))
            array_push($resList, $item->id);
            // else if (isset($item->id))
                // array_push($resList, $item->id);

        }
        return $resList;
    }
}

if (! function_exists('timeToAgo')) {
    function timeToAgo($inputTime){
        $carbonTime = Carbon::parse($inputTime);
        $time = Carbon::now()->diffInSeconds($carbonTime);
        $day = floor($time / 86400);
        $hour = floor(($time - $day * 86400) / 3600);
        $min = floor(($time - $hour * 3600) / 60);
        $sec = floor($time - $hour * 3600 - $min * 60);
        if ($day > 0)
            return $day . ' روز پیش ';
        if ($hour > 0)
            return $hour . ' ساعت پیش ';
        if ($min > 0)
            return $min . ' دقیقه پیش ';
        return $sec . ' ثانیه پیش ';
    }
}
