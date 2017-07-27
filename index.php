<?php 
define('ROOT_PATH',realpath('./'));
define('CORE',ROOT_PATH.'/core');
define('APP_PATH',ROOT_PATH.'/Application');
define('DEBUG',true);
define('DS',DIRECTORY_SEPARATOR);

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

\core\Smart::run();