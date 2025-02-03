<?php
declare (strict_types = 1);
namespace capitan;
use capitan\route\Param;
use capitan\route\Rule;
class Route
{
    protected $routes = [];
    protected $ctrl = /* controller路径 */'main\http\controllers\\';
    protected $uri = /* 获取浏览器URL */'';

    protected $config = /* 初始化配置文件 */[
        'separator' =>  /* 分隔符 */'/',
        'suffix'    =>  /* 控制器后缀名 */false
    ];

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        
        extract(main()->getIniFile('route'));
        Rule::$rules = array_merge(Rule::$rules,$rules);
        $this->config = array_merge($this->config,$config);

    }
    /* ****************************
     * !PURPOSE: 设置路由
     * OUTPUT: String
     **************************** */
    public function set() : void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->add($requestMethod, $this->path(), $this->newController());
        $this->dispatch($requestMethod, $this->path());
    }
    /* ****************************
     * PURPOSE: 添加路由
     * INPUT: 
     *      $mtd<String>: 请求方法(method)
     *          'GET', 'POST', 'PUT', 'DELETE'
     *      $ctrl<String>: 控制器(new controller)
     *      $mtds<Array>: 方法名(methods) [new main\http\controller\index, fn<name>]
     * OUTPUT: Null
     **************************** */
    protected function add(String $mtd, String $ctrl, Array $mtds) : void
    {
        $ctrl = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $ctrl);
        $ctrl = '#^' . $ctrl . '$#';
        $this->routes[] = compact('mtd', 'ctrl', 'mtds');
    }
    /* ****************************
     * PURPOSE: 调度请求
     * INPUT: 
     *     $mtd<String>: 请求方法(method)
     *          'GET', 'POST', 'PUT', 'DELETE'
     *     $ctrl<String>: $this->path()
     * OUTPUT: 
     **************************** */
    protected function dispatch(String $mtd, String $ctrl) : void
    {
        foreach ($this->routes as $route) {
            if ($route['mtd'] === $mtd && preg_match($route['ctrl'], $ctrl, $matches)) {
                call_user_func_array($route['mtds'], array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY));
            }
        }
        // return '404 Not Found';
    }
    /* ****************************
     * PURPOSE: 绑定自定义路由
     * INPUT: 
     *     
     * OUTPUT: String   <module>/<controller>/<action>
     **************************** */
    public function bind()
    {
        $uri = /* 移除第一个'/' */ltrim($this->uri,'/');

        $rulesKey = Rule::parsing($uri);
        if ($rulesKey === false) /* 无匹配规则,则返回自然uri <module>/<controller>/<action> */{
            if ($uri === '') return Rule::$rules['/']['template'];
            if (empty(Rule::$rules[$uri])) return $uri;
            return Rule::$rules[$uri]['template'];
            
        }else /* Rule::$rules[argument/{sid}/{id}] */{
            /* 提取 {} 中的内容 */preg_match_all('/\{([a-zA-Z]+)\}/', $rulesKey, $matches);
            
            if (!empty($matches[1])) Param::$data['key'] = $matches[1];
            $rule = Rule::$rules[$rulesKey];
            Param::$data['pattern'] = $rule['pattern'];
            Param::verify();
            return $rule['template'];
        }
    }
    /* ****************************
     * PURPOSE: 获取请求路径
     *          真实的的路径: module(模块名)/controller(控制器名)/action(操作名)
     * OUTPUT: String - Such as: /index/index/index
     **************************** */
    protected function path()
    {
        return parse_url(
            /* Such as: /index/index/index */DIRECTORY_SEPARATOR . $this->bind(), 
            PHP_URL_PATH
        );
    }
    /* ****************************
     * PURPOSE: 创建一个实例  
     * OUTPUT: Array OR String
     **************************** */
    protected function newController() : Array
    {
        try {
            $path = explode('/', trim($this->path(),'/'));
            return [new ($this->ctrl.$path[0])(), $path[2]];
        } catch (\Exception $e) {
            trigger_error('路由不存在:' . $e->getMessage(), E_USER_ERROR);
        }
    }
}