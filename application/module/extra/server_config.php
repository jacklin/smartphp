<?php
return [
	'host' => '0.0.0.0',//服务监听的ip地址
	'port' => '9502',//服务监听的端口
	'mode' => SWOOLE_PROCESS,//服务监听的端口SWOOLE_PROCESS多进程模式（默认）SWOOLE_BASE基本模式
	'sock_type' => SWOOLE_SOCK_TCP,//支持SWOOLE_SOCK_TCP、SWOOLE_SOCK_UDP、SWOOLE_SOCK_TCP6、SWOOLE_SOCK_UDP6、UnixSocket Stream/Dgram 6种
	'option' => [
		'worker_num' => 4, 
		'daemonize' => false,
		'backlog' => 128,
		'pid_file' => RUNTIME_PATH.DS.'server.pid',
		'log_file' => (function(){ //swoole日志目录
			if (!is_dir(RUNTIME_PATH.DS.'log')) {
				return mkdir(RUNTIME_PATH.DS.'log')  ? RUNTIME_PATH.DS.'log'.DS.'swoole.log' : '';
			}
			return RUNTIME_PATH.DS.'log'.DS.'swoole.log';
		})(),
	],//服务运行参数
];