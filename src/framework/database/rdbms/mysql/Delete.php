<?php
/************************************************************************
* @file Delete.php
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
trait Delete
{
   
    public function delete(int|array $key = null) : int
    {
        $statement = $this->mergeSqlStatement(true);
        if ($statement === ''){
            $tableInfo = $this->getKeyFieldInfo();
            $keyFieldName = $tableInfo['Field'];

            if (is_array($key)) {
                $keys = implode(',', $key);
                $kv = "$keyFieldName IN ($keys)";
            }else{
                $kv = "$keyFieldName = $key";
            }
            $WHERE = " WHERE $kv";
        } else{
            $WHERE = $statement;
        }
        
        return $this->exec("DELETE FROM $this->table$WHERE;");
    }
}