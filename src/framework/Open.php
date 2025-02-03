<?php
declare (strict_types = 1);
namespace capitan;
use capitan\Route;
use capitan\debug\Error;
class Open
{
    protected $ini = /* 所有的初始化配置文件 */[
        'route.php'
    ];

    public function __construct()
    {
        // $this->root = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
    }
    public function autoload()
    {
        (new Error)->initialize();
        require_once 'Helpers.php';
        (new Route)->set();
    }
}