<?php 	
namespace core\lib;

/**
* 	路由类
*/
class Route
{
	/**
	 * 访问控制器
	 * @var string
	 */
	public $controller;
	/**
	 * 访问方法
	 * @var string
	 */
	public $action;
	/**
	 * 请求参数;
	 * @var mixed
	 */
	private $requestParam;
	/**
	 * 路由实例
	 * @var Routee
	 */
	private static $route;

	/**
	 * 请求数据对象
	 * @var object
	 */
	private $request = null;
	/**
	 * 路由类构造方法
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T14:18:40+0800
	 */
	public function __construct($request){
		if ($request instanceof \Swoole\Http\Request) {
			$this->request = $request;
		}
	 	$request_uri = $_SERVER['REQUEST_URI']??$request->server['request_uri'];

	 	$uri_arrays = explode('/', trim($request_uri,'/'));
	 	$i = 0;
	 	if (isset($uri_arrays[$i]) && !empty($uri_arrays[$i])) {
	 		if (strstr($uri_arrays[$i],'.php')) {
	 			$i++;
	 		}
		 	$this->controller = $uri_arrays[$i]??'index';
		 	$i++;
	 		if (isset($uri_arrays[$i]) && !empty($uri_arrays[$i])) {
	 			$this->action = $uri_arrays[$i];
	 		}else{
	 			$this->action = 'index';
	 		}
	 	}else{
	 		$this->controller = 'index';
	 		$this->action = 'index';
	 	}
	 	$i++;
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
	 	$this->setRequestParam($request_param);
	}
	/**
	 * 获取实例化后的对象
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T14:18:57+0800
	 * @return   [type]                   [description]
	 */
	private static function getInstance($request=''){
		if (self::$route instanceof self) {
			return self::$route;
		}else{
			self::$route = new self($request);
			return self::$route;
		}
	}
	/**
	 * 注册GET路由
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T14:22:38+0800
	 * @return   [type]                   [description]
	 */
	public static function get($routeAdd){
		self::setRoute($routeAdd,'get');
	}
	private static function setRouteAdd($routeAdd,$routeCategroy){
		if (is_array($routeAdd)) {
			
		}
		switch ($routeCategroy) {
			case 'get':
				
				break;
			
			default:
				# code...
				break;
		}
	}
	/**
	 * 获取访问方法名称
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T16:31:44+0800
	 * @return   string                   方法名称
	 */
	public static function getAction($request=''){
		return self::getInstance($request)->action;
	}
	/**
	 * 获取访问控制器
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T16:32:20+0800
	 * @return   [type]                   [description]
	 */
	public static function getController($request=''){
		return self::getInstance($request)->controller;
	}
	/**
	 * 设置请求参数
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T16:32:36+0800
	 * @param    [type]                   $param [description]
	 */
	private function setRequestParam($param){
		$this->requestParam = $param;
	}
	/**
	 * 获取请求参数与值
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-28T16:32:51+0800
	 * @param    string                   $name 希望获取的参数
	 * @return   array                         
	 */
	public static function getRequestParam($request = '', $name=''){
		if (empty($name)) {
			if (!empty(self::getInstance($request)->request)) {
				$request_method = strtolower(self::requestCategory($request));//请求方法
				switch ($request_method) {
					case 'head':
						$request_data = [];	
						break;
					case 'post':
						# code...
						$request_data=self::getInstance($request)->request->$request_method;//请求数据
						break;
					case 'get':
						# code...
						$request_data=self::getInstance($request)->request->$request_method;//请求数据
						break;
					default:
						$request_data = [];
						break;
				}
				self::getInstance($request)->setRequestParam($request_data);
				return $request_data;
			}else{
				throw new Exception("Error Processing Request");
			}
			return self::getInstance($request)->requestParam;
		}else{
			return self::getInstance($request)->requestParam[$name]??'';
		}
	}

	public static function requestCategory($request = ''){
		if (isset($_SERVER['REQUEST_METHOD'])) {
			return $_SERVER['REQUEST_METHOD'];
		}else{
		 return self::getInstance($request)->request->server['request_method'];
		}
	}
}