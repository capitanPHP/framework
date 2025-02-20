<?php  
namespace capitan\cache;
class Verify
{
   
    public function KV(String|Int $key, String|Array|Int|object $value)
    {
        if (empty($key) || empty($value)) error([
            'message'   =>  'KEY or Value data type error.',
            'code'  =>  1001
        ]);
        if (gettype($key) !== 'string') error([
            'message'   =>  'KEY must be a string.',
            'code'  =>  1001
        ]);
    }
}