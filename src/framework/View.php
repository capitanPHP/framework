<?php
/************************************************************************
* @file View.php
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
use capitan\Route;
use capitan\File;
use capitan\view\Syntax;
class View
{
    use Syntax;
    protected$getViewHtml = '';
    protected$viewFile = '';
    protected$bufferFile = '';
    protected$viewFileObj = null;
    protected$bufferFileObj = null;

    protected$uri = '';
    protected$route = null;
    protected$main = null;

    public $config = [
        'buffer'    => 'view',
        'suffix'    => '.tpl',
        'debug'     => true,
    ];

    public function __construct()
    {
        $container = new \capitan\Container;

        $this->main = $container->analytic('capitan\Main');
        $this->uri = (new Route)->bind();
    }
   
    public function isView(String $vn)
    {
        if (preg_match('/^[A-Za-z0-9\/\-\_\.]+$/',$vn)) {
            $this->viewFile = 
            $this->main->getViewDir(). $vn . $this->config['suffix'];
            $this->viewFileObj = new File($this->viewFile);
            if (!$this->viewFileObj->isFile()) $this->viewFileObj->create();
        }else{
           
        }
    }
   
    public function isBuffer(String $routeRule)
    {
        $this->bufferFile = 
        $this->main->getBufferDir() . $this->config['buffer'] . DIRECTORY_SEPARATOR . md5($routeRule) .'.php';
    }
   
    public function render(...$argv)
    {
       
        if (is_array($argv[0])) {
            $variable = $argv[0];
        }else{
            $this->uri = $argv[0];
            $variable = empty($argv[1]) ? [] : $argv[1];
        }
        
        
       
        $this->isView($this->uri);

       
        $this->isBuffer($this->uri);
       
        $this->bufferFileObj = new File($this->bufferFile);
        if (!$this->bufferFileObj->isFile() || $this->viewFileObj->getMTime() > $this->bufferFileObj->getMTime() || $this->config['debug']) {
            if ($this->bufferFileObj->isFile()) unlink($this->bufferFileObj->getPathname());
            
            $this->getViewHtml = $this->compile(file_get_contents($this->viewFile));
            $this->bufferFileObj->create($this->getViewHtml);
        }
       extract($variable);
       
        ob_start();
        include $this->bufferFile;
        echo ob_get_clean();
	}
}