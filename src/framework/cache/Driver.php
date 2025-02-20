<?php
/************************************************************************
* @file Driver.php
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
namespace capitan\Cache;
use capitan\Cache\Verify;
class Driver extends Verify
{
    protected $driver = null;
    protected $drivers = null;

    public $driverName = null;
    public $diskName = null;

    public $driverDir = null;
   
    public function initd()
    {
        extract(main()->getIniFile('cache'));
        $this->driver = $driver;
        $this->drivers = $drivers;

        extract(array_combine(['_driver','_disk'], preg_split('/\./',$this->driver)));

        $this->driverName = $_driver;
        $this->diskName = $_disk;
    }
   
    public function driver(string $driver) : object
    {
        $this->driverName = $driver;
        return $this;
    }
   
    public function disk(string $disk) : object
    {
        $this->diskName = $disk;
        return $this;
    }
}