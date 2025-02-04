<?php
declare (strict_types = 1);
/************************************************************************
* @file Debug.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
namespace capitan;
use capitan\debug\Error;
use capitan\debug\Dump;
class Debug
{
   
    public static function dump(...$args)
    {
        return Dump::var($args);
    }
   
    public static function error(Array $argument = 
    [
        'message'   =>  '',
        'code'  =>  0
    ])
    {
        throw new Error($argument);
    }
}