<?php 
namespace core\lib;
use core\lib\Request;
/**
* 
*/
class Controller
{
	/**
	 * 判断是否GET请求
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T17:24:12+0800
	 * @return   boolean                  [description]
	 */
	protected function isGet(){
		if (strtolower(Request::requestCategory()) == 'get') {
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
		if (strtolower(Request::requestCategory()) == 'post') {
			return true;
		}else{
			return false;
		}
	}
}