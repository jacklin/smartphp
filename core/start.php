<?php 
namespace core;
/**
* 
*/
class Smart
{
	public static $classMap;

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
			$file_path = strtolower(ROOT_PATH.'/'.$class_fromat.'.php');
			if (is_file($file_path)) {
				include($file_path);
				self::$classMap[$class] = $file_path;
				return true;
			}else{
				return false;
			}
		}
	}

}