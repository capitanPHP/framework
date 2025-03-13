<?php
/************************************************************************
* @file Param.php
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
namespace capitan\route;
trait Param
{
   
    public function getParam(...$argument)
    {
        $params = $this->getParams();
        if (count($argument) === 0) return $params;

        return empty($params[$argument[0]]) ? null : $params[$argument[0]];
    }
   
    public function getParams() : array
    {
        $ruleKey = $this->parsingRule();
        $rulesKey =preg_split('/[\/\-_]/',$ruleKey);
        $uris =preg_split('/[\/\-_]/',$this->uri);

       
        $differ = count($rulesKey) - count($uris);
        if ($differ > 0){
            for ($i=0; $i < $differ; $i++) { 
                $uris[] = null;
            }
        }else{
            $uris = array_slice($uris,0,count($rulesKey));
        }

       
        $params = [];
        foreach (array_combine($rulesKey,$uris) as $key => $value) {
            preg_match('/\{([a-zA-Z]+)\}/', $key, $matches);
            count($matches) > 0 && $params[$matches[1]] = $value;
        }

        
        $params =array_filter($params);
       
        $iniActiveRule = $this->rules[$ruleKey];
        $patterns =$iniActiveRule['pattern'];
        
        if (!empty($pattern)){
           
            array_filter($patterns,function($pattern,$key) use ($params){
                if (preg_match("/$pattern/",$params[$key]) === 0) {
                    
                    error([
                        'message'   =>  $key . ' = ' . $params[$key] .': Not a valid parameter',
                        'code'  =>  0
                    ]);
                }
            },ARRAY_FILTER_USE_BOTH);
        }

       
        return $params;
    }
}
