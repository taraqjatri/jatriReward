<?php

use Illuminate\Support\Facades\DB;

if (! function_exists('getStoppageById')) {
    function getStoppageById($id, $model){
        if ($model == 'j_vehicle_companies') return DB::table('j_stoppages')->select('name')->where('id', $id)->first();
        else return DB::connection(config('database.intercity_periphery'))
            ->table('intercity_counters')->select('name')->where('id', $id)->first();
    }
}
