<?php
/************************************************************************
* @file Traversal.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare (strict_types = 1);
namespace capitan\view;
trait Traversal {
   
    protected function traversal(String $template) : String
    {
        $template = $this->for($template);
        $template = $this->endfor($template);

        $template = $this->foreach($template);
        $template = $this->endforeach($template);
        return $template;
    }
   
    protected function for(String $template) : String
    {
        return preg_replace_callback('/%\s*for\s*\((.*?)\)\s*%/', function ($mts) {
           
            $conditional = $mts[1];
            
            return "<?php for ($conditional): ?>";
        },$template);
    }
    protected function endfor(String $template) : String
    {
        return preg_replace_callback('/%\s*\/\s*for\s*%/', function ($mts) {
           
            return "<?php endfor;?>";
        },$template);
    }
   
    protected function foreach(String $template) : String
    {
        return preg_replace_callback('/%\s*foreach\s*\((.*?)\)\s*%/', function ($mts) {
           
            $conditional = $mts[1];

            return "<?php foreach ($conditional):?>";
        },$template);
    }
    protected function endforeach(String $template) : String
    {
        return preg_replace_callback('/%\s*\/\s*foreach\s*%/', function ($mts) {
           
            return "<?php endforeach;?>";
        },$template);
    }
}