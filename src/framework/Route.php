<?php
declare (strict_types = 1);
namespace capitan;
class Route
{
    protected $routes = [];
    protected $ctrl = 'main\http\controller\\';
    /*****************************
     * !PURPOSE: 设置路由
     * OUTPUT: String
     *****************************/
    public function set()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->add($requestMethod, $this->path(), $this->verifyPath());
        return $this->dispatch($requestMethod, $this->path());
    }
    /*****************************
     * PURPOSE: 添加路由
     * INPUT: 
     *      $mtd<String>: 请求方法(method)
     *          'GET', 'POST', 'PUT', 'DELETE'
     *      $ctrl<String>: 控制器(new controller)
     *      $mtds<Array>: 方法名(methods) [new main\http\controller\index, fn<name>]
     * OUTPUT: Null
     *****************************/
    protected function add($mtd, $ctrl, $mtds)
    {
        $ctrl = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $ctrl);
        $ctrl = '#^' . $ctrl . '$#';
        $this->routes[] = compact('mtd', 'ctrl', 'mtds');
    }
    /*****************************
     * PURPOSE: 调度请求
     * INPUT: 
     *     $mtd<String>: 请求方法(method)
     *          'GET', 'POST', 'PUT', 'DELETE'
     *     $ctrl<String>: $this->path()
     * OUTPUT: 
     *****************************/
    protected function dispatch($mtd, $ctrl)
    {
        foreach ($this->routes as $route) {
            if ($route['mtd'] === $mtd && preg_match($route['ctrl'], $ctrl, $matches)) {
                return call_user_func_array($route['mtds'], array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY));
            }
        }
        return '404 Not Found';
    }
    /*****************************
     * PURPOSE: 获取请求路径
     * OUTPUT: String - Such as: /index/index/index
     *****************************/
    protected function path()
    {
        return parse_url(
            /* Such as: /index/index/index */$_SERVER['REQUEST_URI'], 
            PHP_URL_PATH
        );
    }
    /*****************************
     * PURPOSE: 验证请求路径  
     * OUTPUT: Array OR String
     *****************************/
    protected function verifyPath()
    {
        try {
            $path = explode('/', trim($this->path(),'/'));
            return [new ($this->ctrl.$path[0])(), $path[2]];
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}