<?php 
namespace core\lib;

/**
* 
*/
class Request
{

	/**
	 * 访问方法
	 * @var string
	 */
	public $action;
	/**
	 * $_SERVER;
	 * @var mixed
	 */
	public $server;

	public function __construct(){
	 	$this->server = array_change_key_case($_SERVER);
	}
	/**
	 * get请求参数
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-04-15T14:38:28+0800
	 * @return   [type]                   [description]
	 */
	public function get(){
		if (!empty($_GET)) {
			return $_GET;
		}else{
			$request_uri = $this->server['request_uri'];
		 	$uri_arrays = explode('/', trim($request_uri,'/'));
		 	$i = 3;
		 	//uri参数部份
		 	$uri_param=array_slice($uri_arrays, $i);
		 	$j = 0;
		 	$request_param = [];//get参数 
		 	while ( $j < count($uri_param)) {
		 		if (isset($uri_param[$j+1])) {
		 			$key = $uri_param[$j];
		 			$request_param[$key] = $uri_param[$j+1];
		 		}
		 		$j+=2;
		 	}
		 	return $request_param;
		}
	}
	/**
	 * post请求参数
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-04-15T14:38:49+0800
	 * @return   [type]                   [description]
	 */
	public function post(){
		return $_POST;
	}
	/**
	 * 文件请求
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-04-15T14:39:03+0800
	 * @return   [type]                   [description]
	 */
	public function file(){
		return $_FILE;
	}
	/**
	 * server 信息
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-04-15T14:39:51+0800
	 * @return   [type]                   [description]
	 */
	public function server(){
		return $_SERVER;
	}
	public function __get($name){
		if (method_exists($this, $name)) {
			return $this->$name();
		}else{
			throw new \Exception("Notice: Undefined property:".$name);
		}
	}
}
