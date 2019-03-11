<?php 
namespace core\lib;

use core\lib\Config;
/**
 * 
 */
class Websocketcontroller
{
	public $server;
	public $frame; //数据帧

	public function __construct($server,$frame)
	{
		if ($server instanceof  \swoole_websocket_server) {
			$this->server = $server;
		}else{
			throw new \Exception("Websocketcontroller 实例错误");
		}
		$this->frame = $frame;
	}
	/**
	 * 返回响应内容
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2018-08-21T14:11:12+0800
	 * @param    integer                  $code       响应code
	 * @param    string                   $msg        响应内容
	 * @param    boolean                  $isForceClose 是否x强制挂断:true 是,false 否
	 * @return   void                              void
	 */
	public function response($code=4000,$msg='',$isForceClose=false){
		if ($isForceClose) {//是否强制挂断
			if (method_exists($this->server, 'disconnect')) {
				if (!$this->server->disconnect($this->frame->fd,$code,$msg)) {
					$this->server->push($this->frame->fd,$msg);
					$this->server->close($this->frame->fd);
				}
			}else{
				$this->server->push($this->frame->fd,$msg);
				$this->server->close($this->frame->fd);
			}
		}else{
			$this->server->push($this->frame->fd,$msg);
		}
	}
	/**
	 * 获取错误响应数据
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2016-11-28T11:54:39+0800
	 * @version  [3.0.0]
	 * @param    string                   $validateFunc 报错方法名称
	 * @param    string                   $validateType 报错类型：validate|break|behavior
	 * @return   array                                  错误信息
	 */
	protected function errorResponseData($validateFunc,$validateType='validate'){
		$error_response_data = [
						'sub_code' => 'invalid.'.$validateType.'.'.$validateFunc,
						'sub_msg' => $this->error ?? "未知错误"
					];
		return $error_response_data;
	}
	/**
	 * 设置响应数据
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2018-08-21T15:26:49+0800
	 * @param    array                    $data [description]
	 * @param    [type]                   $code [description]
	 */
	protected function setResponseData(array $data, $code){
		$public_response = ['code' => $code, 'msg' => Config::get('error_code.'.$code)];
		$action_response = $data;
		$this->responseData = [
			$this->responseActionKey => $action_response,
			'public_response' => $public_response
		];
	}
	/**
	 * 获取响应数据
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2018-08-21T15:26:29+0800
	 * @return   [type]                   [description]
	 */
	protected function getResponseData(){
		return $this->responseData;
	}
	/**
	 * 设置响应访问键名
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2018-08-21T15:25:54+0800
	 * @param    string                   $action 方法名
	 */
	protected function setResponseActionKey(string $action){
		$this->responseActionKey = strtolower($action) . "_response";
		return $this;
	}
}