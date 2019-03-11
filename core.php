<?php 
//目录分隔符定义
define('DS',DIRECTORY_SEPARATOR);
//项目主目录
define('ROOT_PATH',realpath('./'));
//核心程序目录
define('CORE',ROOT_PATH.DS.'core');
//应用名称
define('APP_NAME', 'application');
//应用目录
define('APP_PATH',ROOT_PATH.DS.APP_NAME);
//应用命令空间
define('APP_NAMESPACE','api');
//默认模块
define('DEFAULT_MODULE','module');
//配置文件后缀
define('CONF_EXT','.php');
//运行目录
define('RUNTIME_PATH',ROOT_PATH . DS . 'runtime');

//是否调试
define('DEBUG',true);

if (DEBUG === true) {
	ini_set('display_errors', 'on');
}else{
	ini_set('display_errors', 'off');
}

/**
 * 引入框架函数库
 */
require_once(CORE . DS. 'common' . DS . 'function.php');
/**
 * 引入框架
 */
require_once(CORE . DS. 'start.php');
/**
 * 引入第三方类库
 */
require_once(ROOT_PATH . DS . 'vendor' . DS . 'autoload.php');
/**
 * 启动框架
 */
\core\Smart::run();
