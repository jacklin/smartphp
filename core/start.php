<?php 
namespace core;

use core\lib\Route;
/**
* 
*/
class Smart
{
	/**
	 * 加载的类集合
	 * @var array
	 */
	public static $classMap;
	/**
	 * 路由
	 * @var Route
	 */
	public static $route;

	public function __construct(){

	}
	/**
	 * 执行方法
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-27T18:28:41+0800
	 * @return   void                   [description]
	 */
	public static function run(){
		try {
			spl_autoload_register("self::autoLoad");
			self::initRoute();
		} catch (Exception $e) {
			dd($e->getMessage());
		}
	}
	/**
	 * 自动加载方法
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-27T18:29:24+0800
	 * @param    [type]                   $class 需要加载的类方法
	 * @return   boolean                          
	 */
	public static function autoLoad($class){
		if (isset(self::$classMap[$class])) {
			return true;
		}else{
			$class_fromat = str_replace('\\', '/', $class);
			$class_file = strtolower(ROOT_PATH.'/'.$class_fromat.'.php');
			if (is_file($class_file)) {
				include($class_file);
				self::$classMap[$class] = $class_file;
				return true;
			}else{
				$class = str_replace(APP_NAMESPACE, APP_NAME, $class);
				return self::autoLoad($class);
			}
		}
	}
	private static function initRoute(){
		$action = self::parseName(Route::getAction());
		$controller = self::parseName(Route::getController(),1);

		$class = '\\'.APP_NAMESPACE.'\\'.DEFAULT_MODULE.'\\controller\\'.$controller;
		$app = new $class();
		/**
		 * 访问应用方法
		 * @var [type]
		 */
		$result = $app->$action(Route::getRequestParam());
	}
	/**
	 * 解析类名
	 * 如果有带_下划线的自动转为驼峰规则返回
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T15:33:28+0800
	 * @param    string                   $name 需要转的名字
	 * @param    int                   $strStyle 0首字母大写驼峰风格,1为首字母小写驼峰风格
	 * @return   [type]                         [description]
	 */
	private static function parseName($name,$strStyle=0){
		if (strstr($name , '_')) {
			$name = str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ', $name))));
		}else{
			$name = ucfirst($name);
		}
		if ($strStyle == 1) {
			$name = lcfirst($name);
		}
		return $name;
	}
}