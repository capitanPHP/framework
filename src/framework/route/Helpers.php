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
namespace capitan\route;
trait Helpers
{
   
    public function removeDynamicParam(String $uri) : String
    {
        return parse_url($uri)['path'];
    }
}