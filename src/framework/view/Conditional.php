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
namespace capitan\view;
trait Conditional
{
   
    protected function conditional(String $template) : String
    {
        $template = $this->if($template);
        $template = $this->else($template);
        $template = $this->elseif($template);
        $template = $this->endif($template);

        $template = $this->switch($template);
        $template = $this->endswitch($template);
        return $template;
    }
   
    protected function if(String $template) : String
    {
        return preg_replace_callback('/%\s*if\s*\\((.*?)\)\s*%/', function ($mts) {
           
            $conditional = $mts[1];
            return "<?php if ($conditional): ?>";
        },$template);
    }
    protected function else(String $template) : String
    {
        return preg_replace_callback('/%\s*else\s*%/', function ($mts) {
           
            return "<?php else:?>";
        },$template);
    }
    protected function elseif(String $template) : String
    {
        return preg_replace_callback('/%\s*else\s*if\s*\\((.*?)\)\s*%/', function ($mts) {
           
            $conditional = $mts[1];
            return "<?php elseif ($conditional):?>";
        },$template);
    }
    protected function endif(String $template) : String
    {
        return preg_replace_callback('/%\s*\/s*if\s*%/', function ($mts) {
           
            return "<?php endif;?>";
        },$template);
    }
   
    protected function switch(String $template) : String
    {
        return preg_replace_callback('/%\s*switch\s*\\((.*?)\)\s*%/', function ($mts) {
           
            
            $value = $mts[1];
            return "<?php switch ($value):";
        },$template);
    }
    protected function endswitch(String $template) : String
    {
        return preg_replace_callback('/%\s*\/s*switch\s*%/', function ($mts) {
           
            return "endswitch;?>";
        },$template);
    }
   
    protected function ternary(String $template) : String
    {
        
    }
}