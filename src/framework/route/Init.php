<?php
/************************************************************************
* @file Init.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
namespace capitan\route;
class Init
{
    use Rule,Param,\capitan\main\Get;
    protected $routes = [];
    protected $rules =[
        '/'  =>  [
            'template' =>  'index/index/index'
        ],
    ];
    protected $data =[
        'key' => [],
        'value' => [],
        'param'    =>  [],
        'pattern'   => []
    ];
    protected $ctrl ='main\http\controllers\\';
    protected $uri ='';

    protected $config =[
        'separator' => '/',
        'suffix'    => false
    ];

    protected $inis =[];

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        extract($this->getIniFile('route'));
        $this->rules = array_merge($this->rules,$rules);
        $this->config = array_merge($this->config,$config);

    }
}