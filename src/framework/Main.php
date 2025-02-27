<?php
/************************************************************************
* @file Main.php
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
class Main
{
    const VERSION = '0.0.2';
    public function __construct()
    {
        
    }
    public function getVersion()
    {
        return self::VERSION;
    }
    public function getFrameworkDir()
    {
        return __DIR__ . DIRECTORY_SEPARATOR;
    }
    public function getRootDir()
    {
        return dirname($this->getFrameworkDir(), 5) . DIRECTORY_SEPARATOR;
    }
    public function getMainDir()
    {
        return $this->getRootDir() . 'main' . DIRECTORY_SEPARATOR;
    }
    public function getBufferDir()
    {
        return $this->getRootDir() . 'buffer' . DIRECTORY_SEPARATOR;
    }
    public function getIniDir()
    {
        return $this->getRootDir() . 'ini' . DIRECTORY_SEPARATOR;
    }
    public function getIniFile(String $fn)
    {
        return require $this->getIniDir() . $fn . '.php';
    }
    public function getViewDir()
    {
        return $this->getRootDir() . 'view' . DIRECTORY_SEPARATOR;
    }
}