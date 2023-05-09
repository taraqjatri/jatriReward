<?php
if (!function_exists('getCustomWeekStartAndEndDateFromADateString')) {
    function getCustomWeekStartAndEndDateFromADateString(string $dateTimeString = 'now'): array
    {
        $cal_instance = \IntlCalendar::createInstance();
        $thisWeek = $cal_instance::fromDateTime(new \DateTime($dateTimeString));
        $thisWeek->set($cal_instance::FIELD_DAY_OF_WEEK, $thisWeek->getFirstDayOfWeek()); // $thisWeek now points to the first day of the week
        $returnDates['start_date'] = $thisWeek->toDateTime();
        $thisWeek->set($cal_instance::FIELD_DAY_OF_WEEK, $cal_instance::DOW_SATURDAY); // $thisWeek now points to the last day of the week
        $returnDates['end_date'] = $thisWeek->toDateTime();
        return $returnDates;
    }

}
if (!function_exists('getTypeWiseFromDateToDate')) {
    function getTypeWiseFromDateToDate( $type = \App\Constants\QueryVariation::DAILY): array
    {
        $from = $to = date_create();
        if ($type == \App\Constants\QueryVariation::WEEKLY) {
            $returned_dates = getCustomWeekStartAndEndDateFromADateString();
            $from = $returned_dates['start_date'];
            $to = $returned_dates['end_date'];
        } else if ($type == \App\Constants\QueryVariation::MONTHLY) {
            $from = date_create('first day of this month');
            $to = date_create('last day of this month');;
        }
        return array('from' => $from, 'to' => $to);
    }

}
if (!function_exists('getDetailsFromAPNR')) {
    function getDetailsFromAPNR( string $pnr): array
    {
        $pnr_details['product_code'] = $pnr[0];
        $pnr_details['counter_man_id'] = (int) substr($pnr, 1, 5 ); // total 5 character
        $pnr_details['ticket_serial'] = (int) substr($pnr, 6 , 5 ); // total 5 character
        return $pnr_details;
    }

}
if (!function_exists('todayDateCacheFormat')) {
    function todayDateCacheFormat(): string
    {
        return date('d_m_Y');
    }

}
if (!function_exists('todayDateDBFormat')) {
    function todayDateDBFormat(): string
    {
        return date('Y-m-d');
    }
}





