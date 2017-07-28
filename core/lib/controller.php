<?php 
namespace core\lib;

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
}