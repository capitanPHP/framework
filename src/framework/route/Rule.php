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
trait Rule
{
   
    public function parsingRule() : String|Bool
    {
       
        $methodNameLen = strpos($this->uri, $this->config['separator']);
        if ($methodNameLen === false) {
           
            $methodName = $this->uri;
        }else{
            $methodName = substr($this->uri, 0, $methodNameLen);
        }
        
        $pattern = '/^' . $methodName . '(?:\/(\{[a-zA-Z]+\}))?(?:\/(\{[a-zA-Z]+\}))?(?:\?.*)?$/';
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
