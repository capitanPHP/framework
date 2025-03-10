<?php
/************************************************************************
* @file Env.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https://opensource.org/license/MIT)
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare(strict_types=1);
namespace capitan;
use capitan\Main;
class Env
{
    private $data = [];
    public function __construct()
    {
        $this->data = parse_ini_file((new Main())->getRootDir().'.env',true,INI_SCANNER_RAW);
    }
    /* ****************************
     * PURPOSE: 获取.env环境变量值
     * INPUT: 
     * 		    $key 
     * 		    $value
     * OUTPUT: 
     *          null | string
     **************************** */
    public static function get(string $key = null,$default = null)
    {
        if ($key === null) return (new self)->data;
        if ($default !== null) {
            if (isset((new self)->data[$key])) return (new self)->data[$key];
            return $default;
        }
        return isset((new self)->data[$key]) ? (new self)->data[$key] : $default;
    }

}