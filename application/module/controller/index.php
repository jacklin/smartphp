<?php 
namespace api\module\controller;

use core\lib\Controller;
use core\lib\Route;
use Predis;
/**
* 
*/
class Index extends Controller
{
	
	public function index($request){
		echo "Hello World!";
		$single_server = array(
		    'host' => '127.0.0.1',
		    'port' => 6379,
		    'database' => 15,
		    'password' => 'bazhanghudong7723&&@#',
		);
		$client = new Predis\Client($single_server);
		$client->set()
	}
}