<?php
/************************************************************************
* @file Route.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https://opensource.org/license/MIT)
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare (strict_types = 1);
namespace capitan;
use capitan\route\Param;
use capitan\route\Rule;
class Route extends \capitan\route\Init
{
   
    public function set() : void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->add($requestMethod, $this->path(), $this->newController());
        $this->dispatch($requestMethod, $this->path());
    }
   
    protected function add(String $mtd, String $ctrl, Array $mtds) : void
    {
        $ctrl = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $ctrl);
        $ctrl = '#^' . $ctrl . '$#';
        $this->routes[] = compact('mtd', 'ctrl', 'mtds');
    }
   
    protected function dispatch(String $mtd, String $ctrl) : void
    {
        foreach ($this->routes as $route) {
            if ($route['mtd'] === $mtd && preg_match($route['ctrl'], $ctrl, $matches)) {
                call_user_func_array($route['mtds'], array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY));
            }
        }
        // return '404 Not Found';
    }
   
    protected function bind()
    {
        $rulesKey =$this->parsingRule();
        if ($rulesKey === false){
            if ($this->uri === '') return$this->rules['/']['template'];
            if (empty($this->rules[$this->uri])) return$this->uri;
            return $this->rules[$this->uri]['template'];
        }else{
            $rule = $this->rules[$rulesKey];
            return $rule['template'];
        }
    }
   
    protected function path()
    {
        return parse_url(
           DIRECTORY_SEPARATOR . $this->bind(), 
            PHP_URL_PATH
        );
    }
   
    protected function newController() : Array
    {
        $path = explode('/', trim($this->path(),'/'));
        return [new ($this->ctrl.$path[0])(), $path[2]];
    }
}