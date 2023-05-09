<?php

namespace App\Helper;

use App\Constants\QueryVariation;
use Carbon\Carbon;

class ControllerHelper
{
    public static function checkAuthorization($access, $roles): bool
    {
        $roles = json_decode($roles == '' ? '[]' : $roles,false);
        if(in_array($access,$roles)){
            return true;
        }else{
            return false;
        }
    }
    public static function getDateDifferenceInDays($from_date, $to_date):int {
        return (int) floor((strtotime($to_date) - strtotime($from_date)) / (60 * 60 * 24));
    }
    public static function getDateDBFormatFromDateRangeSingleValue($date) {
        return date_format(date_create_from_format('d/m/Y', $date), 'Y-m-d');
    }
    public static function getDateDBFormatFromDateRange($date_range):array {
        $date_range = explode(' - ', $date_range);
        $dates['from_date']  = date_format(date_create_from_format('d/m/Y', $date_range[0]), 'Y-m-d');
        $dates['to_date']    = date_format(date_create_from_format('d/m/Y', $date_range[1]), 'Y-m-d');
        return $dates;
    }
    public static function isAllowedDateDiffServiceWise($service, $date_diff): bool
    {
        $is_allowed = false;
        if ($service == 'DASHBOARD') {
            if ($date_diff >= 0 && $date_diff <= config('app.allowed_number_of_days_reporting')) $is_allowed = true;
        }
        return $is_allowed;
    }
    public static function getCustomWeekStartAndEndDateFromADateString(string $dateTimeString = 'now'): array
    {
        $cal_instance = \IntlCalendar::createInstance();
        $thisWeek = $cal_instance::fromDateTime(new \DateTime($dateTimeString));
        $thisWeek->set($cal_instance::FIELD_DAY_OF_WEEK, $thisWeek->getFirstDayOfWeek()); // $thisWeek now points to the first day of the week
        $returnDates['start_date'] = $thisWeek->toDateTime();
        $thisWeek->set($cal_instance::FIELD_DAY_OF_WEEK, $cal_instance::DOW_SATURDAY); // $thisWeek now points to the last day of the week
        $returnDates['end_date'] = $thisWeek->toDateTime();
        return $returnDates;
    }

    public static function getTypeWiseFromDateToDate( $type = \App\Constants\QueryVariation::DAILY): array
    {
        $from = $to = date_create();
        if ($type == \App\Constants\QueryVariation::WEEKLY) {
            $returned_dates = self::getCustomWeekStartAndEndDateFromADateString();
            $from = $returned_dates['start_date'];
            $to = $returned_dates['end_date'];
        } else if ($type == \App\Constants\QueryVariation::MONTHLY) {
            $from = date_create('first day of this month');
            $to = date_create('last day of this month');;
        }

        return array('from' => $from, 'to' => $to);
    }

}
