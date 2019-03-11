<?php
if (!defined('APP_NAME')) exit('Application cannot load !');
if (ENV == 'local') {
	define('CACHE_HOST_1', '127.0.0.1');
	define('CACHE_PWD_1', 'bazhanghudong7723&&@#');
	define('CACHE_DB_SERIAL', 1);

}else{
     //逻辑层缓存redis服务器
    define('CACHE_HOST_1', 'r-bp1a06a0a360e9a4.redis.rds.aliyuncs.com');
    define('CACHE_PWD_1', 'Bazhanghudong7723');
    define('CACHE_DB_SERIAL', 1);
}