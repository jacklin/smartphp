<?php 
namespace api\module\controller;

use core\lib\Controller;
use core\lib\Route;
/**
* 
*/
class Index extends Controller
{
	
	public function index($request){
		echo "Hello World!";
		Route::get('i/i',function(){
			echo "eee";
		});
	}
}