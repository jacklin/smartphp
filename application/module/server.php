<?php 
//加载模块配置
\core\lib\Config::load(strtolower(APP_PATH . DS . DEFAULT_MODULE . DS . 'config.php')); 
//自动加载扩展的配置
\core\lib\Config::get('server_config.');
//进入命令行模式
command_handler();

