<?php 
namespace api\module\controller;

use core\lib\Controller;
use core\lib\Route;
use core\lib\Config;
use Predis;
use Tool;
/**
* 
*/
class Index extends Controller
{
	public static $redis;
	/**
	 * 初始化方法
	 */
	public function _initial(){
		$single_server = Config::get('redis.single');
		if (self::$redis instanceof Predis\Client) {
		  echo "redis已经实例".PHP_EOL;
		}else{
		  $client = new Predis\Client($single_server);
		   self::$redis = $client;
		}
	}
	public function index(){
		$process = new \swoole_process(function (\swoole_process $process) {
			$url = 'http://appdown.7723.cn/7723box/test/7723_release-v3.2.3_323_2017.11.17-17.10_dev_test.apk';
			Tool\VirusArtists::setTempPath(RUNTIME_PATH);
			$res = Tool\VirusArtists::scanUrlFile($url);
		}, true);

		$process->start();

		$this->response()->write(json_encode($res));

		$this->response()->write('Hello World1');
		$this->response()->write('Hello World2');
		$this->response()->end();

	}
}