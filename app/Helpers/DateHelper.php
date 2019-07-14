<?php


namespace App\Helpers;


use Carbon\Carbon;

class DateHelper
{
    public static function validate($date)
    {
        try {
            Carbon::parse($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
