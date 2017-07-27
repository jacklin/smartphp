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
	public static function run(){
		try {
		spl_autoload_register("self::autoLoad");
		$route = new \core\Route();	
		} catch (Exception $e) {
			dd($e->getMessage());
		}
	}
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