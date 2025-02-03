<?php

/************************************************************************
* @file Error.php
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
        

        $errnos = [
            1   => E_ERROR,
            2   => E_WARNING,
            4   => E_PARSE,
            8   => E_NOTICE,
            256 => E_USER_ERROR,
            512 => E_USER_WARNING,
            1024    => E_USER_NOTICE,
            2047    => E_ALL,
            2048    => E_STRICT,
            4095    => E_ALL,
            4096    => E_RECOVERABLE_ERROR,
            8192    => E_DEPRECATED, 
        ];

        echo $this->template([
            'message'   =>  $errstr,
            'file'   =>  $this->pathLetterFirst(str_replace('$this->main->getRootDir()','',$errfile)),
            'line'   =>  $errline,
            'action'  =>  $errnos[$errno],
            'trace' =>  '',
        ]);
    }
    public function exception($exc)
    {
        echo $this->template([
            'message'   =>  $exc->getMessage(),
            'file'   =>  $this->pathLetterFirst(str_replace($this->main->getRootDir(),'',$exc->getFile())),
            'line'   =>  $exc->getLine(),
            'action'  =>  $exc->getTrace()[0]['function'],
            
            'trace' =>  '',
        ]);
    }
   
    protected function pathLetterFirst(String $path) : String
    {
        returnimplode('/',array_map('ucfirst',explode('/', $path)));
    }
   
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
   
    protected function template(Array $allErrorInfo) : String
    {

        $allErrorInfo = array_merge($allErrorInfo, $this->requestInfo());

        return preg_replace_callback('/\<\%\=(.*?)\%\>/', function($matches) use ($allErrorInfo) {
            $variable =trim($matches[1]);
            return $allErrorInfo[$variable];
        }, file_get_contents($this->main->getFrameworkDir() . 'debug' . DIRECTORY_SEPARATOR . 'Error.tpl'));
    }
}
