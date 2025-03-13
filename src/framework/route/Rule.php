<?php
/************************************************************************
* @file Rule.php
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
namespace capitan\route;
trait Rule
{
   
    public function parsing(String $uri) : String|Bool
    {
        $pattern = $this->conver($uri);
        $result = 
        array_filter(
           array_keys($this->rules), 
            function ($key) use ($pattern){
                return preg_match($pattern, $key);
            }
        );
        return count($result) === 0 ? false : join($result);
    }
}
