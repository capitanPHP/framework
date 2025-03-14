<?php
/************************************************************************
* @file Syntax.php
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
trait Syntax {
    use Variable,File,Conditional,Traversal;
    
    
   
    public function compile(String $template) : String
    {
        $template =preg_replace('/<!--[\s\S]*?-->/','',$template);

        $template = $this->include($template);
        $template = $this->variable($template);
        
        $template = $this->conditional($template);
        $template = $this->traversal($template);
        

        return $template;
    }
}