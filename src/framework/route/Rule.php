<?php
/************************************************************************
* @file Rule.php
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
namespace capitan\route;
class Rule
{

    public static $rules =[
        '/'  =>  [
            'template' =>  'index/index/index'
        ],
    ];
   
    public static function parsing(String $uri) : String|Bool
    {
        $pattern = Param::parsing($uri);
        $result = 
        array_filter(
           array_keys(Rule::$rules), 
            function ($key) use ($pattern){
                return preg_match($pattern, $key);
            }
        );
        return count($result) === 0 ? false : join($result);
    }
}
