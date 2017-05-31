<?php

spl_autoload_register(function($class){
	$root = dirname(__DIR__); //get the parent directory
	$file = $root . '/' .str_replace('\\', '/', $class) . '.php';
	if(is_readable($file)) {
		require $root . '/' . str_replace('\\', '/', $class). '.php';
	}
});

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once dirname(__DIR__) . '/App/Routes/Route.php';
