<?php
namespace capitan\route;
class Rule
{

    public static $rules = /* 初始化路由规则 */[
        '/'  =>  [
            'template' =>  'index/index/index'
        ],
    ];
    /*****************************
     * PURPOSE: 解析
     * INPUT: 
     *     
     * OUTPUT: Array [KEY => "argument/{sid}/{id}"]
     *****************************/
    public static function parsing(String $uri) : String|Bool
    {
        $pattern = Param::parsing($uri);
        $result = 
        array_filter(
            /* 获取Rules Array key */array_keys(Rule::$rules), 
            function ($key) use ($pattern){
                return preg_match($pattern, $key);
            }
        );
        return count($result) === 0 ? false : join($result);
    }
}
