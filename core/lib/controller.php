<?php 
namespace core\lib;

use core\lib\http\Response;
/**
* 
*/
class Controller
{
	public $request = '';//请求句柄
	public $response = '';//响应句柄
	public function __construct($request='', $response=''){
		empty($request) ? "" : $this->request = $request;
		empty($response) ? "" : $this->response = $response;
		$this->_initial();
	}
	protected function _initial(){

	}
	/**
	 * 判断是否GET请求
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T17:24:12+0800
	 * @return   boolean                  [description]
	 */
	protected function isGet(){
		if (strtolower(Route::requestCategory()) == 'get') {
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 判断是否POST请求
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T17:25:06+0800
	 * @return   boolean                  [description]
	 */
	protected function isPost(){
		if (strtolower(Route::requestCategory()) == 'post') {
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 响应方法
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-03-12T15:48:38+0800
	 * @return   [swoole_http_response]                   返回swoole_http_response对象
	 */
	protected function response(){
		if ($this->response instanceof \swoole_http_response) {
			return Response::getInstance($this->response);
		}else{

		}
	}
}