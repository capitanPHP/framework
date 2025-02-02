<?php
declare (strict_types = 1);
namespace capitan;
class Main
{
    const VERSION = '0.0.2';
    public function __construct()
    {
        
    }
    public function getVersion()
    {
        return self::VERSION;
    }
    public function getFrameworkDir()
    {
        return __DIR__ . DIRECTORY_SEPARATOR;
    }
    public function getRootDir()
    {
        return dirname($this->getFrameworkDir(), 5) . DIRECTORY_SEPARATOR;
    }
    public function getMainDir()
    {
        return $this->getRootDir() . 'main' . DIRECTORY_SEPARATOR;
    }
    public function getLogsDir()
    {
        return $this->getRootDir() . 'logs' . DIRECTORY_SEPARATOR;
    }
    public function getBufferDir()
    {
        return $this->getRootDir() . 'buffer' . DIRECTORY_SEPARATOR;
    }
    public function getIniDir()/* Initialization初始化配置文件夹路径 */
    {
        return $this->getRootDir() . 'ini' . DIRECTORY_SEPARATOR;
    }
    public function getIniFile(String $fn)/* 加载ini中的配置 */
    {
        return require $this->getIniDir() . $fn . '.php';
    }
    public function getViewDir()
    {
        return $this->getRootDir() . 'view' . DIRECTORY_SEPARATOR;
    }
}