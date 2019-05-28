<?php 
define('ROOT_PATH',__DIR__.'');

require_once(ROOT_PATH.'/vendor/autoload.php');

use \BaZhangApiTools\Major;

$r = new Major('7723cn_android_phone','IjDDYBvi51Qtre24Ol13XgdwiIE75bVwDJXvNT6Df38JHQFg1uk3LBq70s3g8G44','http://gateway.dev.7723.com/index.php');
// $r->setDefaultJsonDecoder(true);
echo "<pre>";
// get使用方法一
var_dump($r->app__i('get',['id'=>1,'fields' =>'*'],['version'=>'3.0.0']));
// get使用方法二
// $r->setDefaultJsonDecoder(true);
// var_dump($r->app__i('get',['id'=>1,'fields' =>'*']));
// get使用方法三
// var_dump($r->setDefaultJsonDecoder(true)->app__i('get',['id'=>1,'fields' =>'*']));

// post使用方法一
// var_dump($r->app__a('post',['app_id' => '7723cn_android_phone_1S2','iv'=>'0123456789012345']));
// post使用方法二
// $r->setDefaultJsonDecoder(true);
// var_dump($r->app__a('post',['app_id' => '7723cn_android_phone_1S2','iv'=>'0123456789012345']));
// post使用方法三
// var_dump($r->setDefaultJsonDecoder(true)->app__a('post',['app_id' => '7723cn_android_phone_1S2','iv'=>'0123456789012345']));
// 
//文件上传方法
var_dump($r->user__h('post',['uid' => 1,'mod'=>'avatar','avatar' =>'@D:\\aa.jpg'],['version'=>'3.0.0']));
/**
 * 注：
 * 接口调用方法参数分别：string请求类型[get|post]，array请求内容[必选定]，array请求头[可选]
 */

