<?php 
if (!function_exists('dd')) {
	/**
	 * 调试函数
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2017-07-27T18:18:30+0800
	 * @param    mixed                  $debugContent 待调试内容
	 * @return   [type]                                 输出内容
	 */
	function dd($debugContent){
		$trace = (new \Exception())->getTrace()[0];
		echo '<br/>文件行号:' . $trace['file'] . ':' . $trace['line'];
		echo '<pre>';		
		if (is_array($debugContent)) {
			var_dump($debugContent);
		}elseif (is_string($debugContent)) {
			echo $debugContent;
		}else{
			print_r($debugContent);
		}
		echo '</pre>';
		exit;
	}
}
if (!function_exists('ee')) {
	function ee($tipContent,$outPutContent){
		echo $tipContent.ucfirst($key).":".$value.PHP_EOL;
		if (is_array($outPutContent)) {
			foreach ($outPutContent as $key => $value) {
				ee($tipContent,$value);
			}
		}
	}
}
if (!function_exists('format_response_data')) {
	function format_response_data(array $data, $options=0){
		return json_encode($data,$options);
	}
}

/**
 * 检查cli模式下的运行环境
 */
if (!function_exists('check_cli_env')) {
	function check_cli_env(){
	    if(version_compare(phpversion('swoole'),'1.9.5','<')){
	        die("swoole version must >= 1.9.5");
	    }
	    if(version_compare(phpversion(),'7.0.0','<')){
	        die("php version must >= 7.0.0");
	    }
	}
}
/**
 * 获取运行命令与参数
 */
if (!function_exists('command_parser')) {
	function command_parser(){
	    global $argv;
	    $command = '';
	    $options = array();
	    if(isset($argv[1])){
	        $command = $argv[1];
	    }
	    foreach ($argv as $item){
	        if(substr($item,0,2) === '--'){
	            $temp = trim($item,"--");
	            $temp = explode("-",$temp);
	            $key = array_shift($temp);
	            $options[$key] = array_shift($temp) ?: '';
	        }
	    }
	    return array(
	        "command"=>$command,
	        "options"=>$options
	    );
	}
}
if (!function_exists('command_handler')) {
	function command_handler(){
	    $command = command_parser();
	    switch ($command['command']){
	        case "start":{
	            start_server($command['options']);
	            break;
	        }
	        case 'stop':{
	            stop_server($command['options']);
	            break;
	        }
	        case 'reload':{
	            reload_server($command['options']);
	            break;
	        }
	        case 'update':{
	            echo "Project under construction.".PHP_EOL;
	            break;
	        }
	        case 'version':{
	            echo "Project under construction.".PHP_EOL;
	            break;
	        }
	        case 'help':
	        default:{
	            server_help($command['options']);
	        }

	    }
	}
}

if (!function_exists('start_server')) {
	function start_server($options){
	    $log = 'SmartPHP'.PHP_EOL;
	    /*
	     * 设置参数
	     */
	    foreach ($options as $key => $value) {
		    if (strpos( $key , '=' ) !== false) {
		    	$k_v = explode('=', $key);
		    	list($k,$v) = $k_v;
		    }else{
		    	if ($value) {
			    	$k = $key;
			    	$k_v = explode('=', $value);
			    	list($_k,$v) = $k_v;
		    	}else{
		    		$k = $key;
		    	}
		    }
	    	switch ($k) {
	    		case 'd':
	    			\core\lib\Config::set('server_config.option.daemonize' , true);
	    			break;
	    		case 'port':
	    			\core\lib\Config::set('server_config.port' , $v);
	    			break;
	    		case 'pid':
	    			\core\lib\Config::set('server_config.option.pid_file' , $v);
	    			break;
	    		case 'worker':
	    			\core\lib\Config::set('server_config.option.worker_num' , $v);
	    			break;
	    		default:
				
	    			break;
	    	}

	    }
	    echo "Server Host:".\core\lib\Config::get('server_config.host').PHP_EOL;
	    echo "Server Port:".\core\lib\Config::get('server_config.port').PHP_EOL;
	    foreach (\core\lib\Config::get('server_config.option') as $key => $value) {
	        echo "Server ".ucfirst($key).":".$value.PHP_EOL;
	    }
	    //启动服务器
	    $ws = new \core\lib\httpserver(\core\lib\Config::get('server_config.host'),\core\lib\Config::get('server_config.port'),\core\lib\Config::get('server_config.option'));

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
	    $ws->start();
	}
}
if (!function_exists('stop_server')) {
	function stop_server($options){
		foreach ($options as $key => $value) {
		    if (strpos( $key , '=' ) !== false) {
		    	$k_v = explode('=', $key);
		    	list($k,$v) = $k_v;
		    }else{
		    	if ($value) {
			    	$k = $key;
			    	$k_v = explode('=', $value);
			    	list($_k,$v) = $k_v;
		    	}else{
		    		$k = $key;
		    		$v = null;
		    	}
		    }
			$options[$k] = $v;
		}
	    $pid_file = \core\lib\Config::get('server_config.option.pid_file');
	    if(!empty($options['pid'])){
	        $pid_file = $options['pid'];
	    }
	    if(!file_exists($pid_file)){
	        echo "pid file :{$pid_file} not exist \n";
	        return;
	    }
	    $pid = file_get_contents($pid_file);
	    if(!\swoole_process::kill($pid,0)){
	        echo "pid :{$pid} not exist \n";
	        return;
	    }
	    if(isset($options['f'])){
	        \swoole_process::kill($pid,SIGKILL);
	    }else{
	        \swoole_process::kill($pid);
	    }
	    //等待两秒
	    $time = time();
	    while (true){
	        usleep(1000);
	        if(!\swoole_process::kill($pid,0)){
	            echo "server stop at ".date("Y-m-d h:i:s")."\n";
	            if(is_file($pid_file)){
	                unlink($pid_file);
	            }
	            break;
	        }else{
	            if(time() - $time > 2){
	                echo "stop server fail.try -f again \n";
	                break;
	            }
	        }
	    }
	}
}
if (!function_exists('reload_server')) {
	function reload_server($options){
	   $pid_file = \core\lib\Config::get('server_config.option.pid_file');
	    if(isset($options['pid'])){
	        if(!empty($options['pid'])){
	            $pid_file = $options['pid'];
	        }
	    }
	    if(isset($options['all']) && $options['all'] == false){
	        $sig = SIGUSR2;
	    }else{
	        $sig = SIGUSR1;
	    }
	    if(!file_exists($pid_file)){
	        echo "pid file :{$pid_file} not exist \n";
	        return;
	    }
	    $pid = file_get_contents($pid_file);
	    if(!\swoole_process::kill($pid,0)){
	        echo "pid :{$pid} not exist \n";
	        return;
	    }
	    \swoole_process::kill($pid,$sig);
	    echo "send server reload command at ".date("Y-m-d h:i:s")."\n";
	}
}
if (!function_exists('server_help')) {
	function server_help($options){
	    $opName = '';
	    $args = array_keys($options);
	    if(isset($args[0])){
	        $opName = $args[0];
	    }
	    switch ($opName){
	        case 'start':{
	            echo "------------SmartPHP 启动命令------------\n";
	            echo "执行php server.php start 即可启动服务。启动可选参数为:\n";
	            echo "--d                       是否以系统守护模式运行\n";
	            echo "--p            			指定服务监听端口如 start --p=9502 \n";
	            echo "--pid           		指定服务PID存储文件 如start --pid=/data/file-name.pid \n";
	            echo "--worker			    设置worker进程数 如start --worker=5 \n";
	            break;
	        }
	        case 'stop':{
	            echo "------------SmartPHP 停止命令------------\n";
	            echo "执行php server.php stop 	即可停止服务。停止可选参数为:\n";
	            echo "--pid        		指定服务PID存储文件 如stop --pid=/data/file-name.pid\n";
	            echo "--f                   	强制停止服务\n";
	            break;
	        }
	        case 'reload':{
	            echo "------------SmartPHP 重启命令------------\n";
	            echo "执行php server.php reload	即可重启服务。重启可选参数为:\n";
	            echo "--pid       		指定服务PID存储文件 如reload --pid=/data/file-name.pid\n";
	            echo "--all             		是否重启所有进程，默认true\n";
	            break;
	        }
	        case 'update':{
	            break;
	        }
	        default:{
	            echo "------------欢迎使用SmartPHP------------\n";
	            echo "有关某个命令的详细信息，请使用 help 命令, 如help --start 可选参数为:\n";
	            echo "--start            启动SmartPHP\n";
	            echo "--stop             停止SmartPHP\n";
	            echo "--reload           重启SmartPHP\n";
	            echo "--update           更新框架文件\n";
	        }
	    }
	}
}
