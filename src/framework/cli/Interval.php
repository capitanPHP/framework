<?php
/************************************************************************
* @file Interval.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
namespace capitan\cli;
use capitan\Debug;
class Interval
{
    protected static$running = true;
    protected static$intervals = [];

    protected static $stopTime = false;
   
    public static function timers()
    {
        $intervalTime = self::$intervals->intervalTime;
        $stopTime =self::isCallbackTime();

       
        pcntl_signal(SIGALRM,[self::class,'signalEvent']);
       
        if ($stopTime > 0) pcntl_alarm($stopTime);

       
        while (self::$running) {
            pcntl_signal_dispatch();
           
            if (self::isTaskTime() && $stopTime === 0) {
                self::task();
            }else{
                echo 'Task not started '. date('Y-m-d H:i:s') . PHP_EOL;
            };
            sleep($intervalTime);
        }
    }
   
    protected static function signalEvent($signo)
    {
        switch ($signo) {
            case SIGALRM:
                self::callback();
                self::$running = false;
                echo 'Timer stopped ' . date("Y-m-d H:i:s") . PHP_EOL;
                break;
            default:
               
        }
    }
   
    public static function parem(String|false $interval)
    {
        if (empty($interval)) return null;
        self::$intervals = new ('main\cli\controllers\\'. $interval);
        return true;
    }
   
    protected static function isTaskTime()
    {
        if (self::$intervals->taskTime === 0) return true;

       
        $timeDiff= strtotime(self::$intervals->taskTime) - time();
        return $timeDiff >= 0? false : true ;
    }
   
    protected static function isCallbackTime() : int|false
    {
        if (self::$intervals->callbackTime === 0) return 0;

        $timeDiff = strtotime(self::$intervals->callbackTime) - time();
        return $timeDiff > 0? $timeDiff : false;
    }
   
    public static function task()
    {
        call_user_func_array([self::$intervals, 'task'],[]);
    }
   
    public static function callback()
    {
        call_user_func_array([self::$intervals, 'callback'],[]);
    }
}
