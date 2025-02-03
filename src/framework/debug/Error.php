<?php
namespace capitan\debug;
use capitan\Main;
class Error extends \Exception
{
    protected $main = null;
    public function __construct(Array $argument = 
    [
        'message'   =>  '',
        'code'  =>  0
    ])
    {
        extract($argument);
        parent::__construct($message, $code);
    }
    public function initialize()
    {
        set_error_handler([$this,'error']);
        set_exception_handler([$this, 'exception']);

        $this->main = new Main();
    }
    public function error($errno, $errstr, $errfile, $errline)
    {
        dump([$errno, $errstr, $errfile, $errline]);

        // $errnos = [
        //     1   =>  /* 致命性运行时错误 */E_ERROR,
        //     2   =>  /* 运行时警告（非致命性错误） */E_WARNING,
        //     4   =>  /* 编译时解析错误。 */E_PARSE,
        //     8   =>  /* 运行时提醒（可能存在错误的情况） */E_NOTICE,
        //     256 =>  /* 用户生成的错误消息 */E_USER_ERROR,
        //     512 =>  /* 用户生成的警告消息 */E_USER_WARNING,
        //     1024    =>  /* 用户生成的通知消息 */E_USER_NOTICE,
        //     2047    =>  /* 所有错误和警告（不包括 E_STRICT） */E_ALL,
        //     2048    =>  /* 关于兼容性和最佳实践的通知 */E_STRICT,
        //     4095    =>  /* 所有错误、警告和提醒（包括 E_STRICT） */E_ALL (4095),
        //     4096    =>  /* 捕捉可恢复的致命错误 */E_RECOVERABLE_ERROR,
        //     8192    =>  /* 使用已弃用的功能的消息 */E_DEPRECATED, 
        // ];

        // echo $this->template([
        //     'message'   =>  $errstr,
        //     'file'   =>  $this->pathLetterFirst(str_replace('$this->main->getRootDir()','',$errfile)),
        //     'line'   =>  $errline,
        //     'action'  =>  $errnos[$errno],
        //     'trace' =>  '',
        // ]);
    }
    public function exception($exc)
    {
        echo $this->template([
            'message'   =>  $exc->getMessage(),
            'file'   =>  $this->pathLetterFirst(str_replace($this->main->getRootDir(),'',$exc->getFile())),
            'line'   =>  $exc->getLine(),
            'action'  =>  $exc->getTrace()[0]['function'],
            // 'trace' =>  $exc->getTrace(),
            'trace' =>  '',
        ]);
    }
    /*****************************
     * PURPOSE: 将文件路径的文件夹首字母转成大写
     * INPUT: 
     * 		
     * OUTPUT: 
     *****************************/
    protected function pathLetterFirst(String $path) : String
    {
        return /* 将数组重新组合成字符串 */implode('/', /* 将每个部分的首字母大写 */array_map('ucfirst', /* 将路径按 '/' 分隔成数组 */explode('/', $path)));
    }
    /*****************************
     * PURPOSE: Request 信息
     *          包括: 客户端信息, Cookie, Body
     * OUTPUT: Array
     *****************************/
    protected function requestInfo() : Array
    {
        $requestInfo = [
            'Cookie'    =>  join($_COOKIE),
            'Body'  =>  json_encode($_GET,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        ];

        foreach ([
            'HTTP_ACCEPT',
            'HTTP_ACCEPT_LANGUAGE',
            'HTTP_ACCEPT_ENCODING',
            'HTTP_USER_AGENT',
            'HTTP_UPGRADE_INSECURE_REQUESTS',
            'HTTP_CACHE_CONTROL',
            'HTTP_CONNECTION',
            'HTTP_HOST'
        ] as $key) $requestInfo[$key] = empty($_SERVER[$key]) ? '' : $_SERVER[$key];

        $errorInfo = [
            'phpversion'    =>  phpversion(),
            'capitanversion'    =>  $this->main::VERSION,
        ];

        return array_merge($errorInfo, $requestInfo);
    }
    /*****************************
     * PURPOSE: 模板渲染
     * INPUT: 
     * 		
     * OUTPUT: String
     *****************************/
    protected function template(Array $allErrorInfo) : String
    {

        $allErrorInfo = array_merge($allErrorInfo, $this->requestInfo());

        return preg_replace_callback('/\<\%\=(.*?)\%\>/', function($matches) use ($allErrorInfo) {
            $variable = /* 去除捕获内容中的空格 */trim($matches[1]);
            return $allErrorInfo[$variable];
        }, file_get_contents($this->main->getFrameworkDir() . 'debug' . DIRECTORY_SEPARATOR . 'Error.tpl'));
    }
}
