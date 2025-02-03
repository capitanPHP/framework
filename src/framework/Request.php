<?php
declare (strict_types = 1);
namespace capitan;
class Request
{
    /* ****************************
     * PURPOSE: 请求客户端IP地址
     * INPUT: 
     *     
     * OUTPUT: 
     **************************** */
    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'];

        /*
         * 使用HTTP头信息获取真实IP
         *      - X-Forwarded-For (XFF)
         */

        // if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //     $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        //     $client_ip = trim($ips[0]);
        // } else if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        //     $client_ip = $_SERVER['HTTP_CLIENT_IP'];  
        // }
        // else {
        //     $client_ip = $_SERVER['REMOTE_ADDR'];
        // }
        
        // return $client_ip;

    }
    /* ****************************
     * PURPOSE: 判断或获取请求方法
     *          - [1] GET、POST、PUT、DELETE
     * INPUT: 
     *      $argument[] 如果没有，则返回 Method Name [1]String
     *      $argument['GET'] 判断请求方法是否是GET，并且返回Bool类型
     * OUTPUT: 
     **************************** */
    public function isMethod(...$argument) : String|Bool
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (empty($argument[0])) return $method;
        return strtoupper($argument[0]) === $method;
    }
    /* ****************************
     * PURPOSE: 判断是否是移动端
     * INPUT: 
     *     
     * OUTPUT: 
     **************************** */
    public function isMobile()
    {
        
    }
    /* ****************************
     * PURPOSE: 判断运行设备
     * INPUT: 
     *     
     * OUTPUT: 
     **************************** */
    public function isDevice()
    {
        
    }
}