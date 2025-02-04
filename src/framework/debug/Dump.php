<?php
declare(strict_types=1);
namespace capitan\debug;
class Dump
{
    public static function var($vars)
    {
        ob_start();
        var_dump(...$vars);

        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', ob_get_clean());

        if (PHP_SAPI == 'cli') return PHP_EOL . $output . PHP_EOL;

        $output = preg_replace_callback('/\[(.*?)\] => (string|array|float|int)\((\d+|\d+.\d+)\) "(.*?)"/', function($matches) {
            $keyword = '<span class="keyword">' . $matches[1] . '</span>';
            $type = '<span class="type">' . $matches[2] . '</span>';
            $int = '<span class="number">' . $matches[3] . '</span>';
            $value = '<span class="string">' . $matches[4] . '</span>';

            return "[$keyword] => $type($int) \"$value\"";
        }, $output);
        
        
        
        return '<style>.number{color: red;}.string{color:green;}.type{color:blue;}.keyword{color:purple;}</style>' . '<pre><code>' . $output . '</code></pre>';
    }
}