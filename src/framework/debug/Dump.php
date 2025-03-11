<?php
/************************************************************************
* @file Dump.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare(strict_types=1);
namespace capitan\debug;
class Dump
{
    public static function var($vars)
    {
        ob_start();
        var_dump(...$vars[0]);

        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', ob_get_clean());

        if (PHP_SAPI == 'cli') return PHP_EOL . $output . PHP_EOL;

       
        $output = preg_replace_callback('/\["(.*?)"\]/', function($matches) {
            $key = '<span class="key">' . $matches[1] . '</span>';
            return "[\"$key\"]";
        }, $output);

       
        $output = preg_replace_callback('/(float|int)\((\d+|\d+.\d+)\)/', function($matches) {
            $type = '<span class="type">' . $matches[1] . '</span>';
            $number = '<span class="number">' . $matches[2] . '</span>';
            return "$type($number)";
        }, $output);

       
        $output = preg_replace_callback('/(string)\((\d+|\d+.\d+)\) "(.*?)"/', function($matches) {
            $type = '<span class="type">' . $matches[1] . '</span>';
            $number = '<span class="number">' . $matches[2] . '</span>';
            $value = '<span class="string">' . $matches[3] . '</span>';
            return "$type($number) \"$value\"";
        }, $output);
       
        $output = preg_replace_callback('/(array)\((\d+|\d+.\d+)\) \{/', function($matches) {
            $type = '<span class="type">' . $matches[1] . '</span>';
            $number = '<span class="number">' . $matches[2] . '</span>';
            return "$type($number) {";
        }, $output);
        
        

        return '<style>body{color:#585260;font-size:16px;background-color:#efecf4}body pre{border:1px dashed #bdbac2;border-style:dashed;padding:1em;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;-khtml-border-radius:3px;-o-border-radius:3px}body pre>code>span.number{color:#aa573c}body pre>code>span.string{color:#2a9292}body pre>code>span.type{color:#398bc6}body pre>code>span.key{color:#2a9292}</style>' . '<pre><code>' . $output . '</code></pre>';
    }
}