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
        $weeks = $day / 7;
        $months = $day / 30;
        $years = $months / 12;

        if ($second < 0){
            return $startTime;
        }

        if ($second < 60) {
            return intval($second) . " seconds ago";
        }

        if ($minutes < 60) {
            return intval($minutes) . " minutes ago";
        }

        if ($hour < 24) {
            return intval($hour) . " hours ago";
        }

        if ($day < 7) {
            return intval($day) . " dates ago";
        }

        if ($day < 30) {
            return intval($weeks) . " weeks ago";
        }

        if ($months < 13) {
            return intval($months) . " months ago";
        }

        if ($months > 13) {
            return intval($years) . " years ago";
        }

        return $startTime;
    }
}


