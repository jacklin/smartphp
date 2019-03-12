<?php 
namespace core\lib\http;

/**
 * 
 */
class Response
{
	public $swoole_http_response = ''; //swoole_http_response
	public static $instance = null; //实例

	public function __construct($response){
		if ($response instanceof \swoole_http_response) {
			$this->swoole_http_response = $response;
		}else{

		}
	}
	public static function getInstance($response = null){
	    if($response !== null){
	       self::$instance = new Response($response);
	    }
	    return self::$instance;
	}
	public function end($context=''){
		$this->swoole_http_response->end($context);
	}

	public function __call($method,$params){
		foreach ($params as $key => $value) {
			$this->swoole_http_response->$method($value);
		}
	}
}
