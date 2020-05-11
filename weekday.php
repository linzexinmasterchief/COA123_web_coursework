<?php
    // function used to determine weekdays
    function weekday($date_arr) {
        // using Zeller's rule to determine weekdays, reference: http://mathforum.org/dr.math/faq/faq.calendar.html
        $day_of_month = (float)$date_arr[0];
        // month -2 to make formula more simple
        $month = (float)$date_arr[1] - 2;
        if ($month < 0) {
            // Jan => 11, Feb => 12
            $month = $month + 12;
        }
        $year_last_2_digit = (float)$date_arr[2] % 100;
        if ($month >= 11) {
            // Jan and Feb are put into last year since month -2 above
            $year_last_2_digit = $year_last_2_digit - 1;
        }
        $century = (float)$date_arr[2] / 100;
        $f = $day_of_month + ((13 * $month - 1) / 5) + $year_last_2_digit + ($year_last_2_digit / 4) + ($century / 4) - 2 * $century;
        while ($f < 0) {
            $f += 7;
        }
        $day_in_week = $f % 7;
        // 0 is sunday, 6 is saturday
        return $day_in_week;
    }
?>