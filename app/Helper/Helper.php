<?php

/**
 * format number by 0.000.000
 *
 * @param int $number
 * @return string
 */
if (!function_exists('formatNumber')){
    function formatNumber(int $number): string
    {
        return number_format($number,0,'.','.');
    }
}

/**
 * format dateTime by day ago
 *
 * @param string $dateTime
 * @return string
 */
if (!function_exists('formatDayAgo')){
    function formatDayAgo(string $dateTime): string
    {
        $startTime = date('H:i:s d-m-Y', strtotime($dateTime));
        $endTime = date('H:i:s d-m-Y');
        $second = strtotime($endTime) - strtotime($startTime);
        $minutes = $second / 60;
        $hour = $minutes / 60;
        $day = $hour / 24;

        if ($second < 0){
            return $startTime;
        }

        if ($second < 60) {
            return intval($second) . "s";
        }

        if ($minutes < 60) {
            return intval($minutes) . "m";
        }

        if ($hour < 24) {
            return intval($hour) . "h";
        }

        if ($day < 30) {
            return intval($day) . "d";
        }

        return $startTime;
    }
}


