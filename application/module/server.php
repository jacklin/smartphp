<?php 
use core\lib\Config;

Config::load(strtolower(APP_PATH . DS . DEFAULT_MODULE . DS . 'config.php'));

$ws = new core\lib\httpserver(Config::get('server_config.host'),Config::get('server_config.port'),Config::get('server_config.option'));

//close
$ws->on('close', function ($ser, $fd) {
    echo "Bye {$fd} \n";
    // unset($access_object);
});
//request
$ws->on('request', function ($request, $response) {
    // 接收http请求从get获取message参数的值，给用户推送
    //启动框架
    \core\Smart::webrun($request, $response);
     // $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});

echo "Server Host:".Config::get('server_config.host').PHP_EOL;
echo "Server Port:".Config::get('server_config.port').PHP_EOL;
foreach (Config::get('server_config.option') as $key => $value) {
    echo "Server ".ucfirst($key).":".$value.PHP_EOL;
}
$ws->start();