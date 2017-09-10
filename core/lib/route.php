<?php 	
namespace core\lib;
/**
* 	路由类
* 	所有的请求支持方法POST|GET|数据类型默认使用请求的数据类型，同时使用
* 	GET使用方法如下:
* 	Route::get('C/A',"RealC/RealA[string|function]");
* 	Route::get('C/:id',"RealC/RealA[string|function]",'dataType'); //dataType[int|string|array]
* 	
* 	POST使用方法如下:
* 	Route::post('C/A',"RealC/Real/A[string|function]");
* 	Route::post('C/:id',"RealC/RealA[string|function]",'dataType'); //dataType[int|string|array]
*
*   任何模式请求方法如下:
* 	Route::any('C/A',"RealC/RealA[string|function]");
* 	Route::post('C/:id',"RealC/RealA",'dataType'); //dataType[int|string|array]
*
* 	
* 	Route::miss('*',"RealC/RealA[string|function]");
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
						}else{

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

