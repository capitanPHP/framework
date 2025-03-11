<?php
/************************************************************************
* @file Table.php
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
namespace capitan\database\rdbms\mysql;
use PDO;
trait Table
{
   
    public function table(string $table) : self
    {
        $this->table = $table;
        return $this;
    }
   
    public function name(string $name) : self
    {
        $this->table = $this->inis['prefix'].$name;
        return $this;
    }
   
    public function field(string|array $field,bool $not = false) : self
    {
        if ($not){
            $allField = $this->getFieldNames();
            $field = is_array($field) ? $field : explode(',',$field);
            $field =array_diff(array_values($this->getFieldNames()),$field);
        }

        $this->field = is_array($field) ? implode(',',$field) : $field;
        return $this;
    }
   
    public function order() : self
    {
        $this->order = 'ORDER BY';
        return $this;
    }
   
    public function getKeyFieldInfo() : array
    {
        $p = $this->prepare("DESCRIBE `$this->table`;");
        $p->execute();
        return $p->fetch(PDO::FETCH_ASSOC);
    }
   
    public function getFieldNames() : array
    {
        $p = $this->prepare("SHOW COLUMNS FROM `$this->table`;");
        $p->execute();
        return $p->fetchAll(PDO::FETCH_COLUMN);
    }
}