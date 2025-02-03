<?php
/************************************************************************
* @file Request.php
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
class Request
{
   
    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'];

       

        
        
        
        
        
        
        
        
        
        
        

    }
   
    public function isMethod(...$argument) : String|Bool
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (empty($argument[0])) return $method;
        return strtoupper($argument[0]) === $method;
    }
   
    public function isMobile()
    {
        
    }
   
    public function isDevice()
    {
        
    }
}