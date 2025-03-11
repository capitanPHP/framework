<?php
/************************************************************************
* @file Helpers.php
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
trait Helpers
{
   
    public function mergeSqlStatement(bool $sql = false)
    {
        $statementS = '';
       
        if ($sql === true) {
            foreach ($this->statement as $key => $value) {
                foreach ($this->statement[$key] as $key2 => $value2) {
                    $this->statement[$key][$key2] = implode(" $key2 ",array_unique($this->statement[$key][$key2]));
                }
            }
            
            if (!empty($this->statement['WHERE']['AND'])) {
                $statementS .= $this->statement['WHERE']['AND'];
            }
            if (!empty($this->statement['WHERE']['OR'])) {
                $statementS .= ' OR '.$this->statement['WHERE']['OR'];
            }
            if ($statementS !== '') $statementS = " WHERE $statementS";
            

            $this->statement =[];
            return$statementS;
        }
        return $this->statement;
    }
}