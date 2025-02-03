<?php
/************************************************************************
* @file Syntax.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https://opensource.org/license/MIT)
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
declare (strict_types = 1);
namespace capitan\view;
use capitan\Main;
use capitan\View;
class Syntax {
    protected static $main = null;
    protected static $view = null;
   
    protected static function variable(String $htmlTemplate) : String
    {
        return preg_replace_callback('/<%(\=|\-)\s*([a-zA-Z0-9_]+)\s*%>/', function($matches) {
            $symbol = trim($matches[1]);
            $name = trim($matches[2]);
            if ($symbol === '-') return '<?php echo $' . $name . '; ?>';
            if ($symbol === '=') return '<?php echo htmlspecialchars($' . $name . '); ?>';
        }, $htmlTemplate);
    }
   
    protected static function include(String $htmlTemplate) : String
    {
        return preg_replace_callback('/<%(\=|\-)\s*include\((.*?)\)\s*%>/', function($matches) {
            $pathFile = 
            self::$main->getViewDir() . 
            trim($matches[2],"'\"") . 
            self::$view->config['suffix'];

            return "<?php include('{$pathFile}'); ?>";
        }, $htmlTemplate);
    }
   
    public static function compile(String $htmlTemplate) : String
    {
        self::$main = new Main();
        self::$view = new View();

        $template = self::variable($htmlTemplate);
        $template = self::include($template);

        return $template;
    }
}