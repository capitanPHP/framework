<?php
/************************************************************************
* @file Helpers.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https://opensource.org/license/MIT)
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare(strict_types=1);
use capitan\Debug;
use capitan\Container;

if (function_exists('dump') === false) {
    function dump(...$args)
    {
        Debug::dump($args);
    }
}
if (function_exists('error') === false) {
    function error(Array $argument = 
    [
        'message'   =>  '',
        'code'  =>  0
    ])
    {
        Debug::error($argument);
    }
}
if (function_exists('main') === false) {
    function main()
    {
        return ((new Container)->analytic('capitan\Main'));
    }
}