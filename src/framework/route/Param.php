<?php
/************************************************************************
* @file Param.php
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
class Param
{
    public static $data =[
        'key' => [],
        'value' => [],
        'param'    =>  [],
        'pattern'   => []
    ];
   
    public static function get(...$argument)
    {
        $param = self::$data['param'];
        if (count($argument) === 0) return $param;

        return empty($param[$argument[0]]) ? null : $param[$argument[0]];
    }
   
    public static function verify() : void
    {
        if (empty(Param::$data['key']))return;
        self::$data['param'] = 
        array_combine(Param::$data['key'],Param::$data['value']);
        extract(Param::$data);

        if (empty(Param::$data['pattern']))return;
        
        $param =array_filter($param);
        if (count($param)) {
            array_filter($pattern,function($value,$key) use ($param){
                if (preg_match('/' . $value . '/',$param[$key]) === 0) {
                    throw new \Exception($key . ' = ' . $param[$key] .': 不是有效的参数');
                }
            },ARRAY_FILTER_USE_BOTH);
        }
        Param::$data['param'] =$param;
    }
   
    public static function parsing(String $uri) : String
    {
        $uris =preg_split('/[\/\-_]/',self::filterNative($uri));
        switch (count($uris)) {
            case 1:
                [
                    $name
                ] = $uris;
                break;
            case 2:
                [
                    $name, 
                    $p1
                ] = $uris;
                break;
            default:
                [
                    $name, 
                   $p1, 
                   $p2
                ] = $uris;
                break;
        }

        $p1 = isset($p1) ? $p1 : null;
        $p2 = isset($p2) ? $p2 : null;

        self::$data['value'] = [$p1,$p2];
        return '/^' .self::filterNative($name) . '(?:\/(\{[a-zA-Z]+\}))?(?:\/(\{[a-zA-Z]+\}))?(?:\?.*)?$/';

        // return '/^' .parse_url($name)['path'] . '\/(\{[a-zA-Z]+\})(?:\/(\{[a-zA-Z]+\}))?$/';
    }
   
    public static function filterNative(String $path) : String
    {
        return parse_url($path)['path'];
    }
}
