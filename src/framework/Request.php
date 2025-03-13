<?php
/************************************************************************
* @file Request.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https://opensource.org/license/MIT)
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare (strict_types = 1);
namespace capitan;
use capitan\Route;
class Request
{
    public $server = [];

    public function __construct()
    {
        $this->server = $_SERVER;
    }

   
    public function ip()
    {
        return $this->server['REMOTE_ADDR'];

       

        // if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //     $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        //     $client_ip = trim($ips[0]);
        // } else if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        //     $client_ip = $_SERVER['HTTP_CLIENT_IP'];  
        // }
        // else {
        //     $client_ip = $_SERVER['REMOTE_ADDR'];
        // }
        
        // return $client_ip;

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
   
    public function getParam(...$argument) : Array|String|Null
    {
        $uri = parse_url($this->server['REQUEST_URI']);
        if (empty($uri['query'])) {
            $param = [];
        }else{
            parse_str($uri['query'], $param);
        }
        $params = array_merge((new Route)->getParam(),$param);
        if (count($argument) === 0) return $params;
        return empty($params[$argument[0]]) ? null : $params[$argument[0]];
    }
    public function getHost()
    {
        return $this->server['HTTP_HOST'];
    }
}