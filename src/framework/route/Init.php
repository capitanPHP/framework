<?php
/************************************************************************
* @file Init.php
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
class Init
{
    use Rule,Param,Helpers,\capitan\main\Get;
   
    private static $init = false;

    protected $routes = [];
    protected $rules =[
        '/'  =>  [
            'template' =>  'index/index/index'
        ],
    ];
    public $params =[
        'key' => [],
        'value' => [],
        'param'    => [],
        'pattern'   => []
    ];
    protected $ctrl ='main\http\controllers\\';
    protected $uri ='';

    protected $config =[
        'separator' => '/',
        'suffix'    => false
    ];

    protected $request =null;

    public function __construct()
    {
        $this->uri = $this->removeDynamicParam(ltrim($_SERVER['REQUEST_URI'],'/'));
        extract($this->getIniFile('route'));
        $this->rules = array_merge($this->rules,$rules);
        $this->config = array_merge($this->config,$config);
    }
}