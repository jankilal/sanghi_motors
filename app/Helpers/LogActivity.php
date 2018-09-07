<?php


namespace App\Helpers;
use Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{


    public static function addToLog($subject,$grievance_id = 0, $status_id = 0, $action_id = 0, $UserId = 0)
    {
        //Get USer ID
        //$UserId = 0;
        $user_email = '';
        if(auth()->check()){
            $UserId = auth()->user()->id;
            $user_email = auth()->user()->email;
        }
        if(auth()->guard('api')->user()){
            $UserId = auth()->guard('api')->user()->id;
            $user_email =auth()->guard('api')->user()->email;
        }

            $log = [];
            $log['subject'] = $subject;
            $log['url'] = Request::fullUrl();
            $log['method'] = Request::method();
            $log['ip'] = Request::ip();
            $log['agent'] = Request::header('user-agent');
            $log['user_id'] = $UserId;
            $log['grievance_id'] = $grievance_id;
            $log['status_id'] = $status_id;
            $log['action_id'] = $action_id;
            LogActivityModel::create($log);


    }


    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }


}