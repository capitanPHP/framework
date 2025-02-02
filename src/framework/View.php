<?php
declare (strict_types = 1);
namespace capitan;
use capitan\Route;
use capitan\File;
class View
{
    protected /* 获取view中的模版文件 */$getViewHtml = '';
    protected /* 视图文件 */$viewFile = '';
    protected /* 缓存文件 */$bufferFile = '';
    protected /* 视图文件spl */$viewFileObj = null;
    protected /* 缓存文件spl */$bufferFileObj = null;

    protected /* 路由地址 */$uri = '';
    protected /* Route Class */$route = null;
    protected /* Main Class */$main = null;

    public $config = [
        'buffer'    =>  /* 缓冲区 */'view',
        'suffix'    =>  /* 视图模版后缀 */'.tpl'
    ];

    public function __construct()
    {
        $container = new \capitan\Container;

        $this->main = $container->analytic('capitan\Main');
        $this->uri = (new Route)->bind();
    }
    /*****************************
     * PURPOSE: 判断视图名称格式并且创建视图模版文件
     * INPUT: 
     *      $vn 视图名称
     * OUTPUT: 
     *****************************/
    public function isView(String $vn)
    {
        if (preg_match('/^[A-Za-z0-9\/\-\_\.]+$/',$vn)) {
            $this->viewFile = 
            $this->main->getViewDir(). $vn . $this->config['suffix'];
            $this->viewFileObj = new File($this->viewFile);
            if (!$this->viewFileObj->isFile()) $this->viewFileObj->create();
        }else{
            /* 错误信息: 模版名称格式错误 */
        }
    }
    /*****************************
     * PURPOSE: 视图模版缓存
     * INPUT: 
     *     
     * OUTPUT: 
     *****************************/
    public function isBuffer(String $routeRule)
    {
        $this->bufferFile = 
        $this->main->getBufferDir() . $this->config['buffer'] . DIRECTORY_SEPARATOR . md5($routeRule) .'.php';
    }
    /*****************************
     * PURPOSE: 渲染
     * INPUT: 如果$agre参数 = [0,1]
     *     $agre[0]<String|Array> view模版路径或变量Array
     *     $agre[1]<Array> 变量Array
     * OUTPUT: 
     *****************************/
    public function render(...$argv)
    {
        /* 如果不是字符串，那么就是数组 */
        if (is_array($argv[0])) {
            $variable = $argv[0];
        }else/* 如果$argv[0]变量是字符串的话，那么$argv[1]必须是数组 */{
            $this->uri = $argv[0];
            $variable = empty($argv[1]) ? [] : $argv[1];
        }
        
        /* view tpl path */ 
        /* 首先判断文件名称格式
         * index-index = index-index.tpl
         * index.index.index = index.index.index.tpl
         * index_index_index = index_index_index.tpl
         * index/index/index = dir/dir/index.tpl
         */
        $this->isView($this->uri);

        /* 
         * Buffer File 
         * 想要动态存储
         * 根据 uri来判断 比如 index/index/index  index/100/1
         */
        $this->isBuffer($this->uri);
        /*
            - 判断缓存文件是否存在，不存在则进行重新编译缓存
            - 如果视图模版进行修改后，则进行重新编译缓存
        */
        $this->bufferFileObj = new File($this->bufferFile);
        if (!$this->bufferFileObj->isFile() || $this->viewFileObj->getMTime() > $this->bufferFileObj->getMTime()) {
            if ($this->bufferFileObj->isFile()) unlink($this->bufferFileObj->getPathname());
            
            $this->getViewHtml = $this->compile(file_get_contents($this->viewFile));
            $this->bufferFileObj->create($this->getViewHtml);
        }
        /* 将数组转变量 */extract($variable);
        // 包含缓存文件并输出
        ob_start();
        include $this->bufferFile;
        echo ob_get_clean();
	}
    /*****************************
     * PURPOSE: 编译HTML To PHP
     * INPUT: 
     *     
     * OUTPUT: String
     *****************************/
    private function compile(String $template) : String
    {
        return $this->variable($template);
    }
    /***************************** /view/render.php
     * PURPOSE: 变量处理
     *          !特殊字符变量处理: 将<%= title %>中的变量替换成php变量<?php echo htmlspecialchars($' . $variable . '); ?>
     * INPUT: 
     *      $template <String>  HTML模版
     * OUTPUT: String
     *****************************/
    public function variable($template)
    {
        $html = preg_replace_callback('/\<\%\=(.*?)\%\>/', function($matches) {
            $variable = /* 去除捕获内容中的空格 */trim($matches[1]);
            return '<?php echo htmlspecialchars($' . $variable . '); ?>';
        }, $template);
        return $html;
    }
}