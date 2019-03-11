<?php 
namespace core\lib;

use core\lib\Parser;

class HttpServer {
    public $server;

    public function __construct($host, $port, $option=[]) {
        $this->server = new \Swoole\Http\Server($host, $port);
        !empty($option)?$this->server->set($option):'';//array('worker_num' => 4,'daemonize' => false,'backlog' => 128,)
    }

   
    public function start(){
    	$this->server->start();
    }

    public function __call($method,$params){
    	if (method_exists($this->server, $method)) {
    		if (isset($params[0]) && isset($params[1])) {
		    	return $this->server->$method($params[0],$params[1]);
    		}else{
    			throw new \Exception("调用参数个数有误");
    		}
    	}else{
			throw new \Exception("调用方法不存在");
    	}
    }
}