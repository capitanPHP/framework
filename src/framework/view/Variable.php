<?php
/************************************************************************
* @file Variable.php
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
trait Variable {
    protected function variable(String $template) : String
    {
        $template = $this->echo($template);
        $template = $this->var($template);
        return $template;
    }
   
    protected function echo(String $template) : String
    {
        return preg_replace_callback('/%(\=|\-)\s*([a-zA-Z_][a-zA-Z0-9_]*(\[[a-zA-Z0-9_]*\])?)\s*%/', function($mts) {
            $symbol = trim($mts[1]);
            $name =trim($mts[2]);
            if (!empty($mts[3])){
                if (strpos($name, '[')!== false) {
                   
                    $name = preg_replace('/\[([a-zA-Z0-9_]+)\]/', '[$${1}]', $name);
                }
            }
            
            
            if ($symbol === '-') return '<?php echo $' . $name . '; ?>';
            if ($symbol === '=') return '<?php echo htmlspecialchars($' . $name . '); ?>';
        }, $template);
    }
   
    protected function var(String $template) : String
    {
        return preg_replace_callback('/%\s*var\s*([a-zA-Z0-9_]+)\s*=\s*(([\s\S]*?))\s*%/', function($mts) {
            $name = trim($mts[1]);
            $value = trim($mts[2]);
            return "<?php \$$name = $value; ?>";
        }, $template);
    }
}