<?php 
//项目主目录
define('ROOT_PATH',realpath('./'));
//核心程序目录
define('CORE',ROOT_PATH.'/core');
//应用名称
define('APP_NAME', 'Application');
//应用目录
define('APP_PATH',ROOT_PATH.'/'.APP_NAME);
//应用命令空间
define('APP_NAMESPACE','api');
//默认模块
define('DEFAULT_MODULE','module');
//是否调试
define('DEBUG',true);
//目录分隔符定义
define('DS',DIRECTORY_SEPARATOR);
//composer提供商目录
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH. DS . 'vendor' . DS);

if (DEBUG === true) {
	ini_set('display_errors', 'on');
}else{
	ini_set('display_errors', 'off');
}

/**
 * 引入框架函数库
 */
require_once(CORE.'/common/function.php');
/**
 * 引入框架
 */
require_once(CORE.'/start.php');
/**
 * 启动框架
 */
\core\Smart::run();