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
