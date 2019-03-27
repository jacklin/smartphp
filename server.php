<?php 	
//引入框架入口文件
require_once(__DIR__ . DIRECTORY_SEPARATOR .'core.php');
//系统环境
define('ENV','remote');
// 导入数据库环境配置
require __DIR__ . DS. 'database.inc.php';
/**
 * 启动框架
 */
\core\Smart::run();

//启动服务器
require APP_PATH . DS . DEFAULT_MODULE . DS . 'server.php';
