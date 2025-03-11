<?php
/************************************************************************
* @file Read.php
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
trait Read {
   
    public function find(int $which = 1) : array|false
    {
        $statement = $this->mergeSqlStatement(true);
        $offset = $which - 1;

        $SQL = "SELECT $this->field FROM $this->table$statement LIMIT :offset,:which";
        $p = $this->prepare($SQL);
        $p->bindParam(':offset', $offset, PDO::PARAM_INT);
        $p->bindParam(':which', $which, PDO::PARAM_INT);
        $p->execute();
        return $p->fetch(PDO::FETCH_ASSOC);
    }
   
    public function select(array $whichs = null) : array
    {
        if ($whichs === null) return $this->all();
        extract(array_combine(['offset','which'],$whichs));
        $statement = $this->mergeSqlStatement(true);

        $SQL = "SELECT $this->field FROM $this->table$statement LIMIT :offset,:which";
        $p = $this->prepare($SQL);
        $p->bindParam(':offset', $offset, PDO::PARAM_INT);
        $p->bindParam(':which', $which, PDO::PARAM_INT);
        $p->execute();
        return $p->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function all()
    {
        $statement = $this->mergeSqlStatement(true);

        $SQL = "SELECT $this->field FROM $this->table$statement";
        $p = $this->prepare($SQL);
        $p->execute();
        return $p->fetchAll(PDO::FETCH_ASSOC);
    }
}