<?php 
namespace core\lib;

class Parser
{

    public static function decode($raw, $client=null)
    {
        // TODO: Implement decode() method.
    	return json_decode($raw,true);
    }

    public static function encode(array $raw, $client=null): string
    {
        return json_encode($raw);
    }
}