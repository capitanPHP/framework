<?php
declare (strict_types = 1);
namespace capitan;
class File extends \SplFileInfo
{
    protected $dir = '';
    protected $getPathType /* type:dir|dile */= 'file';

    public function __construct(String $file = '')
    {
        parent::__construct($file);
        if ($this->getExtension() === '') /* 说明$file是一个文件夹路径 */{
            $this->getPathType = 'dir';
            $this->dir = 
            $this->getPath() . DIRECTORY_SEPARATOR . $this->getBasename();
        }else/* 说明$file是一个文件路径 */{
            $this->getPathType = 'file';
            $this->dir = $this->getPath();
        }
    }
    /* ****************************
     * PURPOSE: 创建文件和文件夹
     *          new File String : /root/dir2/dir3 - 自动创建 dir3 目录
     *          new File String : /root/dir2/dir3/file.tpl - 自动创建 dir3 目录，并且创建*file.tpl文件
     * 
     * INPUT: 
     *      $args[0]<Int|String>  它有可能是$mode或$text
     *      $args[1]<String>  $text
     * OUTPUT: this
     **************************** */
    public function create(...$args) : Object
    {
        $mode = 0777;
        $text = '';
        if (!empty($args[0])) {
            if (is_int($args[0])) $mode = $args[0];
            if (is_string($args[0])) $text = $args[0];
        }
        if (!empty($args[1])) $text = $args[1];

        if ($this->isFile() === false) /* 文件不存在 */{
            if (!file_exists($this->dir) && !is_dir($this->dir)) /* 目录不存在，则创建目录 */mkdir($this->dir, $mode, true);

            if ($this->getPathType === 'file') /* 判断 SplFileInfo 载人的是文件夹，还是文件 */{
                file_put_contents(/* 创建文件 */$this->getPath(). DIRECTORY_SEPARATOR .$this->getFilename(),$text);
            }
            
        }
        return $this;
    }
}
