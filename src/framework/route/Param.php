<?php
namespace capitan\route;
class Param
{
    public static $data = /* 所有参数数据 */[
        'key' =>  /* 参数名称 */[],
        'value' =>  /* 参数值 */[],
        'param'    =>  [],
        'pattern'   =>  /* ini/route.php pattern */[]
    ];
    /* ****************************
     * PURPOSE: 获取参数
     * INPUT: 
     *     $argument 没有传递如何参数则返回全部$data参数
     *     $argument[0]<String> param key 返回指定key的value
     * OUTPUT: 
     **************************** */
    public static function get(...$argument)
    {
        $param = self::$data['param'];
        if (count($argument) === 0) return $param;

        return empty($param[$argument[0]]) ? null : $param[$argument[0]];
    }
    /* ****************************
     * PURPOSE: 验证参数值
     *          - $data param 和 pattern
     *          - pattern 模式对param进行验证
     * INPUT:   
     * OUTPUT: 
     **************************** */
    public static function verify() : void
    {
        self::$data['param'] = 
        array_combine(Param::$data['key'],Param::$data['value']);
        extract(Param::$data);
        
        $param = /* 如果没有参数，则移除无效的key=>null */array_filter($param);
        if (count($param)) {
            array_filter($pattern,function($value,$key) use ($param){
                if (preg_match('/' . $value . '/',$param[$key]) === 0) {
                    throw new \Exception($key . ' = ' . $param[$key] .': 不是有效的参数');
                }
            },ARRAY_FILTER_USE_BOTH);
        }
        Param::$data['param'] = /* 过滤后的参数结构 */$param;
    }
    /* ****************************
     * PURPOSE: 解析参数
     *          - 获取动态参数值
     * INPUT: 
     *      $uri的格式可能是: 
     *          - argument/1/2
     *          - argument-123
     *          - argument_123
     * OUTPUT: String
     **************************** */
    public static function parsing(String $uri) : String
    {
        $uris = /* 将$uri转数组 */preg_split('/[\/\-_]/',$uri);
        switch (count($uris)) {
            case 1:
                [
                    $name
                ] = $uris;
                break;
            case 2:
                [
                    $name, 
                    $p1
                ] = $uris;
                break;
            default:
                [
                    $name, 
                    $p1/* 参数1 */, 
                    $p2/* 参数2 */
                ] = $uris;
                break;
        }

        $p1 = isset($p1) ? $p1 : null;
        $p2 = isset($p2) ? $p2 : null;

        self::$data['value'] = [$p1,$p2];
        return '/^' . /* 移除url后的?# */parse_url($name)['path'] . '\/(\{[a-zA-Z]+\})(?:\/(\{[a-zA-Z]+\}))?$/';
    }
}
