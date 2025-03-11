<?php
/************************************************************************
* @file Write.php
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
trait Write
{
   
    public function insert(array $data) : bool
    {   
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        
        $prepare = $this->prepare("INSERT INTO $this->table ($columns) VALUES ($placeholders)");
        $result = $prepare->execute($data);
        return $result;
    }
   
    public function insertAll(array $data) : bool|int
    {
        $insertCount = 0;
        foreach ($data as $value) if ($this->insert($value)) $insertCount++;
        $adjust = count($data) - $insertCount  === 0;
        if ($adjust === 0) return true;
        return $adjust;
    }
   
    public function update(array $data)
    {
        $statement = $this->mergeSqlStatement(true);
        if ($statement === ''){
            $tableInfo = $this->getKeyFieldInfo();
            $keyFieldName = $tableInfo['Field'];
            $kv = $data[$keyFieldName];
            $WHERE = " WHERE $keyFieldName = $kv";
        } else{
            $WHERE = $statement;
        }

        $sets =[];
        foreach (array_keys($data) as $key) {
            $sets[] = "$key = :$key";
        }
        $sets = implode(', ',$sets);

        $p = 
        $this->prepare("UPDATE $this->table SET $sets$WHERE;");
        $result = $p->execute($data);
        return $result;
    }
   
    public function updateAll(array $data) : bool|int
    {
        $updateCount = 0;
        foreach ($data as $value) if ($this->update($value)) $updateCount++;
        $adjust = count($data) - $updateCount  === 0;
        if ($adjust === 0) return true;
        return $adjust;
    }
}
