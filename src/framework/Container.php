<?php
declare (strict_types = 1);
namespace capitan;
class Container
{
    /*****************************
     * PURPOSE: 
     *          - 单例模式1
     * INPUT: 
     * 		
     * OUTPUT: 
     *****************************/

    // 
    protected $mr = /* 存储绑定的映射关系(Mapping relationship) */[];
    /* ****************************
     * ! #1
     * PURPOSE: 绑定抽象
     *          - 将抽象类、接口或标识符绑定到具体实现类或闭包
     *          - 支持单例模式绑定
     * INPUT: 
     *      $abstract<string> 抽象类、接口或标识符
     *      $concrete<Closure|string|null> Class或Closure
     *      $shared<bool> 是否以单例模式绑定
     * OUTPUT: Null
     **************************** */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        if ($concrete === null) /* 如果未提供具体实现，默认使用抽象类 */$concrete = $abstract;

        $this->mr[$abstract] = /* 存储绑定信息 */[
            'concrete' => $concrete,
            'shared' => $shared,
            'instance' => /* 用于存储单例实例 */null,
        ];
    }
    /* ****************************
     * ! #2
     * PURPOSE: 解析绑定的抽象make
     *          - 解析绑定的抽象，返回具体的实例
     *          - 如果是单例绑定，会返回同一个实例
     * INPUT: 
     *      $abstract<String> 抽象类、接口或标识符
     * OUTPUT: Object
     **************************** */
    public function analytic(String $abstract) : Object
    {
        if (/* 检查是否已绑定 */!isset($this->mr[$abstract])) $this->bind($abstract);

        $binding = $this->mr[$abstract];

        if ($binding['shared'] && $binding['instance'] !== null) /* 如果是单例且已实例化，直接返回实例 */return $binding['instance'];
        
        $concrete = /* 解析具体实现 */$binding['concrete'];
        $instance = 
        gettype($concrete) === 'object' ? 
        /* 如果是闭包，直接调用 */$concrete($this) : 
        /* 如果是类名，实例化 */$this->build($concrete);
        if ($binding['shared']) /* 如果是单例，存储实例 */{
            $this->mr[$abstract]['instance'] = $instance;
        }
        return $instance;
    }
    /* ****************************
     * PURPOSE: 实例化类并自动注入依赖
     *          - 使用反射自动解析类的依赖，并实例化对象
     *          - class 有构造函数(__construct())才会执行$this->build
     * INPUT: 
     *      - $concrete<Object|String> 具体实现类
     * OUTPUT: Object
     **************************** */
    protected function build($concrete) : Object
    {

        $reflector =/* 使用反射获取类的构造函数 */ new \ReflectionClass($concrete);
        if (/* 判断是否是构造函数 */!$reflector->getConstructor()) /* 如果不是构造函数，则直接实例化 */return new $concrete();

            $parameters = /* 获取构造函数的参数 */$reflector->getConstructor()->getParameters();
    
            $dependencies = [];
    
            foreach ($parameters as $parameter) /* 解析每个参数 */{
                $dependency = /* 获取参数的类型提示类 */$parameter->getType();
                if ($dependency === null) {
                    /* 如果没有类型提示，尝试获取默认值 */
                    if ($parameter->isDefaultValueAvailable()) {
                        $dependencies[] = $parameter->getDefaultValue();
                    } else {
                        throw new \Exception("无法解析参数: {$parameter->getName()}");
                    }
                } else {
                    $dependencies[] = /* 递归解析依赖 */$this->analytic($dependency->getName());
                }
            }
            return /* 实例化类并注入依赖 */$reflector->newInstanceArgs($dependencies);
    }
}
