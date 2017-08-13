<?php 	
namespace core\lib;
/**
* 	路由类
*/
class Route
{
	/**
	 * 
	 * @var 路由规则表
	 */
	public static $ruleMap;
	/**
	 * 设置路由规则
	 * @return [type] [description]
	 */
	public static function rule($expression, $realPath){

	}
	public static function __callStatic($func, $arguments){
		[$expression,$realpath] = $arguments;
		if (is_object($realpath)) {
			call_user_func($realpath);
		}elseif (is_string($realpath)) {
			[$controller, $action] = explode('/', $realpath);
			if ($expression) {
				$expression = explode('/', $expression);
				switch ($func) {
					case 'get':
						[$action, $param] = $expression;
						if (strstr($param, ':')) {
							self::$ruleMap[$realpath] = isset(self::$ruleMap[$realpath]) ? self::$ruleMap[$realpath] : $expression;
						}
						break;
					
					default:
						# code...
						break;
				}
			}
		}else{
			throw new \Exception("参数传入有错误");
			
		}
	}
}

