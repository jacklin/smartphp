<?php 	
//引入框架入口文件
require_once(__DIR__.'/core.php');
//系统环境
define('ENV','remote');
// 导入数据库环境配置
require __DIR__ . '/database.inc.php';

use core\lib\Config;

Config::load(strtolower(APP_PATH.DS.DEFAULT_MODULE.DS.'config.php'));

$ws = new core\lib\WebSocket(Config::get('server_config.host'),Config::get('server_config.port'),Config::get('server_config.option'));
//open
$ws->on('open', function (swoole_websocket_server $server, $request) {
    echo "Client:fd{$request->fd}\n";
});
//message
$ws->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    
    if (is_string($frame->data)) {
        $req_data = core\lib\Parser::decode($frame->data);//{"access":{"c":"Index","a":"index"},"require_params":{"game_id":"1000","uid":"10000","token":"1zSacI2c3v91vaxo"}}
        if (isset($req_data['access'])) {
            $c = $req_data['access']['c'] ??  $server->disconnect($frame->fd, 4000, "访问错误:c");
            $a = $req_data['access']['a'] ??  $server->disconnect($frame->fd, 4000, "访问错误:a");
        }else{
            $web_c= new \core\lib\Websocketcontroller($server,$frame);
            $web_c->response( 4000, "访问错误",true);
            if (method_exists($server, 'exists')&&$server->exists($frame->fd)) {
                $server->close($frame->fd);
            }
            return ;
        }
        $c = ucfirst($c);
        $a = strtolower($a);
        if (isset($req_data['require_params'])) {
            $class = "api\WebSocket\controller\\".$c;
            if (isset($access_objects[$class]) && $access_objects[$class] instanceof $class) {
                echo "已经存在访问接口";
            }else{
                $access_object = new $class($server,$frame);
                $access_objects[$class] = $access_object;
            }
            $access_objects[$class]->$a($req_data);
        }else{
            $server->disconnect($frame->fd, 4000, "访问参数错误");
        }
    }
});
//close
$ws->on('close', function ($ser, $fd) {
    echo "Bye {$fd} \n";
    // unset($access_object);
});
//request
$ws->on('request', function ($request, $response) {
    // 接收http请求从get获取message参数的值，给用户推送
    // $ws->connections 遍历所有websocket连接用户的fd，给所有用户推送
    foreach ($ws->connections as $fd) {
        $ws->push($fd, $request->get['message']);
    }
});
echo "Server Host:".Config::get('server_config.host').PHP_EOL;
echo "Server Port:".Config::get('server_config.host').PHP_EOL;
foreach (Config::get('server_config.option') as $key => $value) {
    echo "Server ".ucfirst($key).":".$value.PHP_EOL;
}
$ws->start();