<?php
declare (strict_types = 1);
namespace capitan;
use capitan\debug\Error;
use capitan\debug\Dump;
use capitan\debug\dump\render\CliRenderer;
use capitan\debug\dump\Utilities;
class Debug
{
    /*****************************
     * PURPOSE: 转储器
     * INPUT: 
     *     
     * OUTPUT: 
     *****************************/
    public static function dump(...$args)
    {
        // if (!defined('KINT_DIR')) {
        //     define('KINT_DIR', __DIR__);
        // }
        if (!defined('KINT_PHP80')) {
            define('KINT_PHP80', version_compare(PHP_VERSION, '8.0') >= 0);
        }
        if (!defined('KINT_PHP81')) {
            define('KINT_PHP81', version_compare(PHP_VERSION, '8.1') >= 0);
        }
        if (!defined('KINT_PHP82')) {
            define('KINT_PHP82', version_compare(PHP_VERSION, '8.2') >= 0);
        }
        if (!defined('KINT_PHP83')) {
            define('KINT_PHP83', version_compare(PHP_VERSION, '8.3') >= 0);
        }
        if (!defined('KINT_PHP84')) {
            define('KINT_PHP84', version_compare(PHP_VERSION, '8.4') >= 0);
        }
        if (!defined('KINT_PHP85')) {
            define('KINT_PHP85', version_compare(PHP_VERSION, '8.5') >= 0);
        }

        
        // 禁止不可读的文档根（与open_basedir相关）
        Utilities::$path_aliases = [
            $_SERVER['DOCUMENT_ROOT'] => '<ROOT>',
        ];
        Utilities::$path_aliases[realpath($_SERVER['DOCUMENT_ROOT'])] = '<ROOT>';
        Utilities::composerSkipFlags();
        
        if (FALSE) /* 高级模式 */{
            return Dump::vars(...$args);
        }else /* 纯文本模式 */{
            if (false === Dump::$enabled_mode) {
                return 0;
            }
    
            $kstash = Dump::$enabled_mode;
            $cstash = CliRenderer::$cli_colors;
            
            if (Dump::MODE_TEXT !== Dump::$enabled_mode) {
                Dump::$enabled_mode = Dump::MODE_PLAIN;

                if (PHP_SAPI === 'cli' && true === Dump::$cli_detection) {
                    Dump::$enabled_mode = Dump::$mode_default_cli;
                }
            }
    
            CliRenderer::$cli_colors = false;
    
            $out = Dump::vars(...$args);
            
            Dump::$enabled_mode = $kstash;
            CliRenderer::$cli_colors = $cstash;
            return $out;
        }
    }
    /*****************************
     * PURPOSE: 异常、错误
     * INPUT: 
     * 		
     * OUTPUT: 
     *****************************/
    public static function error(Array $argument = 
    [
        'message'   =>  '',
        'code'  =>  0
    ])
    {
        throw new Error($argument);
    }
}