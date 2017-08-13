<?php 
use core\Route;

Route::get('Index/index',function(){
	echo "call get";
});
Route::get('i/:id',function(){
	echo "call get";
});