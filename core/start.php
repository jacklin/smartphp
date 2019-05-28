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
		if (!is_dir(RUNTIME_PATH)) {
			mkdir(RUNTIME_PATH);
		}
		try {
			spl_autoload_register("self::autoLoad");
			IS_CLI?check_cli_env():self::initRoute('','');
		} catch (Exception $e) {
			dd($e->getMessage());
		}
	}
	/**
	 * 命令执行方法
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-05-15T14:53:20+0800
	 * @return   [type]                   [description]
	 */
	public static function cmdRun($ctrl='', $action='', $options=''){
		if (!is_dir(RUNTIME_PATH)) {
			mkdir(RUNTIME_PATH);
		}
		try {
			spl_autoload_register("self::autoLoad");
			self::initConsole($ctrl, $action, $options);
		} catch (Exception $e) {
			dd($e->getMessage());
		}
	}
	/**
	 * web执行方法
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-27T18:28:41+0800
	 * @return   void                   [description]
	 */
	public static function webRun($request='', $response=''){
		if (!is_dir(RUNTIME_PATH)) {
			mkdir(RUNTIME_PATH);
		}
		try {
			spl_autoload_register("self::autoLoad");
			self::initRoute($request, $response);
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
				$class_fromat = str_replace('\\', '/', $class);
				$class_file = strtolower(ROOT_PATH.'/'.$class_fromat.'.php');
				if (is_file($class_file)) {
					include($class_file);
					self::$classMap[$class] = $class_file;
					return true;
				}
				return false;
			}
		}
	}
	/**
	 * 初始化路由
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-05-15T14:58:17+0800
	 * @param    string                   $request  请求对象
	 * @param    string                   $response 响应对象
	 * @return   void                             无返回值
	 */
	private static function initRoute($request='', $response=''){
		$action = self::parseName(Route::getAction($request));
		$controller = self::parseName(Route::getController($request),1);

		$class = '\\'.APP_NAMESPACE.'\\'.DEFAULT_MODULE.'\\controller\\'.$controller;

		$app = new $class($request,$response);
		/**
		 * 访问应用方法
		 * @var [type]
		 */
		if ($request) {
			$result = $app->$action(Route::getRequestParam($request));
		}else{
			$result = $app->$action(Route::getRequestParam());
		}
	}
	/**
	 * 初始化控制台
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-05-15T14:58:02+0800
	 * @param    string                   $ctrl   请求控制器
	 * @param    string                   $action 请求控制器方法
	 * @param    string                   $params 传入参数
	 * @return   void                           无返回值
	 */
	private static function initConsole($ctrl='index', $action='index', $params=''){
		$controller = $ctrl;
		$action = $action;
		$class = '\\'.APP_NAMESPACE.'\\'.DEFAULT_MODULE.'\\controller\\'.$controller;
		$app = new $class();
		/**
		 * 访问应用方法
		 * @var [type]
		 */
		$result = $app->$action($params);
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