<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\LogEvent;

class LogEventController extends Controller
{
    public function saveLogEvent($previous_data, $updated_data, $description, $action_by){

        $logEvent = new LogEvent();
        $logEvent->previous_data    = json_encode($previous_data, JSON_UNESCAPED_UNICODE);
        $logEvent->updated_data     = json_encode($updated_data, JSON_UNESCAPED_UNICODE);
        $logEvent->description      = json_encode($description, JSON_UNESCAPED_UNICODE);
        $logEvent->action_by        = json_encode($action_by, JSON_UNESCAPED_UNICODE);

        $logEvent->save();
    }
}
