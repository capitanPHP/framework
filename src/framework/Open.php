<?php
/************************************************************************
* @file Open.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare (strict_types = 1);
namespace capitan;
use capitan\Route;
use capitan\debug\Error;
class Open
{
    protected $ini =[
        'route.php'
    ];

    public function __construct()
    {
        
    }
    public function autoload()
    {
        (new Error)->initialize();
        require_once 'Helpers.php';
        (new Route)->set();
    }
}