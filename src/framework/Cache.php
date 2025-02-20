<?php
/************************************************************************
* @file Cache.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare(strict_types=1);
namespace capitan;
use capitan\Cache\Driver;
use capitan\Cache\Typedef;
class Cache extends Driver implements Typedef
{
    protected $main = null;
    protected $cacheFile= '';
    public function __construct()
    {
        $this->main = new Main();
        $this->initd();
    }
   
    public function set(string $key, string|array|int|object $value, int $expiration = 0) : bool
    {

        $this->KV($key, $value);

       
        if (gettype($expiration) !== 'integer') error([
            'message'   =>  'The expiration time must be a valid integer.',
            'code'  =>  1001
        ]);

        if ($this->has($key)) $this->delete($key);

        $this->fp($key);


       
        if ($expiration > 0) $expiration = time() + $expiration;
        
       
        $caches = [
            'expiration' => $expiration,
            'value'  => $value,
            'time'   => time(),
            'type'   => gettype($value)
        ];

        (new File($this->cacheFile))->create(serialize($caches));
        return true;
    }
   
    public function get(string $key) : string|array|int|object
    {
        if ($this->has($key) === false)return false;
        $caches = unserialize(file_get_contents($this->cacheFile));
       
        if ($caches['expiration'] !== 0){
            if (time() > $caches['expiration']){
                $this->delete($key);
                return false;
            }
        }
        return $caches['value'];
    }
   
    public function has(string $key): bool
    {
        $this->fp($key);
        return (new File($this->cacheFile))->isFile();
    }
   
    public function delete(string $key): bool
    {
        $this->fp($key);
        if ($this->has($key)){
            unlink($this->cacheFile);
            return true;
        }
        return false;
    }
   
    public function fp(string $key) : void
    {
        $str = md5($key);

        

        $pathsStr =substr($str, 0,12);
        $cacheFileName =substr($str, 12,22);
       
        $dirDepth =2;
        $paths =str_split($pathsStr, $dirDepth);

        $this->cacheFile = $this->main->getRootDir() . $this->drivers[$this->driverName][$this->diskName] . DIRECTORY_SEPARATOR . implode('/', $paths) . '/' . $cacheFileName . '.php';
    }
}