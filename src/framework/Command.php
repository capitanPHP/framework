<?php

/************************************************************************
* @file Command.php
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
class Command
{
    protected$param = [];
    public function __construct($argv)
    {
        $this->parem($argv);
        
    }
   
    public function run()
    {
        echo "Starting PHP built-in web server...". PHP_EOL;
        echo 'Listening on http:\/\/'. $this->param['-S'] .':'. $this->param['-P'] .PHP_EOL;
        exec('php -S ' .$this->param['-S']. ':' . $this->param['-P']);
    }
   
    protected function parem($argv)
    {
       array_shift($argv);
        $chunks =array_chunk($argv, 2);
        $this->param =array_combine(array_column($chunks, 0), array_column($chunks, 1));
    }
}