<?php

/************************************************************************
* @file Cli.php
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
namespace capitan;
use capitan\cli\Interval;
class Cli
{
    protected$param = [
        '-S'    => '127.0.0.1',
        '-P'    => 9090,
        'interval'  => null
    ];
    protected $main = null;
    public function __construct($argv)
    {
        $this->main = new Main();
        $this->parem($argv);
    }
   
    public function run()
    {
        
        if ($this->param['interval'] !== null)Interval::timers();

        echo json_encode($this->param). PHP_EOL;

        echo "Starting PHP built-in web server...\n" . PHP_EOL;
        echo 'Listening on '. $this->param['-S'] .':'. $this->param['-P'] .PHP_EOL;
        exec('php -S ' .$this->param['-S']. ':' . $this->param['-P'] . ' -t' . $this->main->getOpenDir());
    }
   
    protected function parem($argv)
    {
       array_shift($argv);
        $chunks =array_chunk($argv, 2);
        $this->param = array_merge($this->param,array_combine(array_column($chunks, 0), array_column($chunks, 1)));

       
        $this->param['interval'] = Interval::parem($this->param['interval']);
    }
}