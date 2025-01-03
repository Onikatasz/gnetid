<?php

use Carbon\Carbon;

if (!function_exists('thisDayOrLast')) {
    /**
     * Adjusts the day to match the given day or the last valid day of the month.
     *
     * @param string|Carbon $date The base date.
     * @param int $day Desired day of the month.
     * @return Carbon Adjusted date.
     */
    function thisDayOrLast($date, $day) {
        $date = Carbon::parse($date);
        $last = $date->copy()->lastOfMonth();

        $date->day = ($day > $last->day) ? $last->day : $day;

        return $date;
    }
}
