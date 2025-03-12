<?php
/************************************************************************
* @file Conditional.php
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
trait Conditional
{
   
    public function where(...$conditional) : self
    {
        $vn =['field','operator','value','LO'];
        
        if (is_array($conditional[0])){
           
            for ($i=0; $i < count($conditional[0]); $i++) {
                $this->where(...$conditional[0][$i]);
            }
        } else{
           
            $num = count($conditional);
            if ($num == 2) {
                array_splice($conditional,1,0,['EQ']);
                array_splice($conditional,3,0,['AND']);
            }
            if ($num == 3) array_splice($conditional,3,0,['AND']);
            extract(array_combine($vn,$conditional));
            $operator =strtoupper($operator);
            if (is_string($value)) $value ="'" . addslashes($value) . "'";
            $LO =strtoupper($LO);
            if (in_array(
                $operator,
                array_merge(
                    array_keys($this->comparisonOperator),
                    array_values($this->comparisonOperator)
                )
            )) {
               
                $operator = ctype_alpha($operator) ? $this->comparisonOperator[$operator] : $operator;
                if (in_array($operator,['BETWEEN','NOT BETWEEN'])) $value = implode(' AND ',$value);
                if (in_array($operator,['IN','NOT IN'])) $value = "(".implode(',',$value).")";
                if ($value === null) $value = 'NULL';
                $this->statement['WHERE'][$LO][] = "$field $operator $value";
            }
        }

        return $this;
    }
}