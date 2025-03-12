<?php
/************************************************************************
* @file File.php
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
namespace capitan\view;
trait File
{
   
    protected function include(String $template) : String
    {
        return preg_replace_callback('/%(\=|\-)\s*include\((.*?)\)\s*%/', function($mts) {
            $file = 
            $this->main->getViewDir() . 
            trim($mts[2],"'\"") . 
            $this->config['suffix'];
            return file_get_contents($file);
           
        }, $template);
    }
}