<?php
/************************************************************************
* @file Container.php
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
class Container
{

    
    protected $mr =[];
   
    public function bind($abstract, $concrete = null, $shared = false)
    {
        if ($concrete === null)$concrete = $abstract;

        $this->mr[$abstract] =[
            'concrete' => $concrete,
            'shared' => $shared,
            'instance' =>null,
        ];
    }
   
    public function analytic(String $abstract) : Object
    {
        if (/* 检查是否已绑定 */!isset($this->mr[$abstract])) $this->bind($abstract);

        $binding = $this->mr[$abstract];

        if ($binding['shared'] && $binding['instance'] !== null)return $binding['instance'];
        
        $concrete =$binding['concrete'];
        $instance = 
        gettype($concrete) === 'object' ? 
       $concrete($this) : 
       $this->build($concrete);
        if ($binding['shared']){
            $this->mr[$abstract]['instance'] = $instance;
        }
        return $instance;
    }
   
    protected function build($concrete) : Object
    {

        $reflector = new \ReflectionClass($concrete);
        if ( !$reflector->getConstructor())return new $concrete();

            $parameters =$reflector->getConstructor()->getParameters();
    
            $dependencies = [];
    
            foreach ($parameters as $parameter){
                $dependency =$parameter->getType();
                if ($dependency === null) {
                   
                    if ($parameter->isDefaultValueAvailable()) {
                        $dependencies[] = $parameter->getDefaultValue();
                    } else {
                        throw new \Exception("无法解析参数: {$parameter->getName()}");
                    }
                } else {
                    $dependencies[] =$this->analytic($dependency->getName());
                }
            }
            return$reflector->newInstanceArgs($dependencies);
    }
}
