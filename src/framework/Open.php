<?php
declare (strict_types = 1);
namespace capitan;
use capitan\Route;
class Open
{
    const VERSION = '0.0.2';
    public function __construct()
    {
        
    }
    public function run()
    {
        return (new Route())->set();
    }
}