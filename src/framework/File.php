<?php
/************************************************************************
* @file File.php
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
class File extends \SplFileInfo
{
    protected $dir = '';
    protected $getPathType= 'file';

    public function __construct(String $file = '')
    {
        parent::__construct($file);
        if ($this->getExtension() === ''){
            $this->getPathType = 'dir';
            $this->dir = 
            $this->getPath() . DIRECTORY_SEPARATOR . $this->getBasename();
        }else{
            $this->getPathType = 'file';
            $this->dir = $this->getPath();
        }
    }
   
    public function create(...$args) : Object
    {
        $mode = 0777;
        $text = '';
        if (!empty($args[0])) {
            if (is_int($args[0])) $mode = $args[0];
            if (is_string($args[0])) $text = $args[0];
        }
        if (!empty($args[1])) $text = $args[1];

        if ($this->isFile() === false){
            if (!file_exists($this->dir) && !is_dir($this->dir)) mkdir($this->dir, $mode, true);

            if ($this->getPathType === 'file'){
                file_put_contents($this->getPath(). DIRECTORY_SEPARATOR .$this->getFilename(),$text);
            }
            
        }
        return $this;
    }
}
