<?php
/************************************************************************
* @file Db.php
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
use capitan\database\rdbms\mysql\Sql as MySQL;
class Db extends MySQL
{
    public $PDO = null;
    protected $inis = [];
    protected $table = '';
    public function __construct()
    {
        parent::__construct();
    }
}