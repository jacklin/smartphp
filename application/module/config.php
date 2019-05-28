<?php 
return [
	/**
	 * redis数据库配置
	 */
	'redis' => [
		'cluster' => [
			[
				'host' => CACHE_HOST_1,
				'port' => 6379,
				'database' => CACHE_DB_SERIAL,
				'password' => CACHE_PWD_1,
				'alias' => 'first',
			],
			[
				'host' => CACHE_HOST_1,
				'port' => 6379,
				'database' => 3,
				'password' => CACHE_PWD_1,
				'alias' => 'second',
			]
		],
		'single' => [
			'host' => CACHE_HOST_1,
			'port' => 6379,
			'database' => CACHE_DB_SERIAL,
			'password' => CACHE_PWD_1,
		]
	],
	'box_api' => [
		'app_id' => '7723cn_android_phone_bbs',
		'app_secret' => 'NEI3J72neSQMew4dz74V3wSJsrW51IQveJdq34o86pLyg53bFZ265FornlunZ92F', 
		'api_url' => APP_API_URL,
	],
	/**
	 * 接口响应代码
	 */
	'error_code' => [
		'4200' =>	'业务处理成功',
		'4001' =>	'授权权限不足',
		'4011' =>	'缺少必选参数',
		'4002' =>	'非法的参数',
		'4004' =>	'业务处理失败',
		'4000' =>	'业务处理中断',
		'4404' =>	'暂无数据',
	],
	'log' => [
		'type' => '',
		'default_log_path' => RUNTIME_PATH. DS . 'logs',
		'default_log_name' => APP_NAME,
		'default_log_suffix' => '.log'
	],
	'app_ini' =>[
		'debug' => DEBUG
	]
];