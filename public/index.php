<?php
//echo 'Requested URL ="' . $_SERVER['QUERY_STRING'] .'"';

// require '../App/Controllers/Posts.php';

// require '../Core/Router.php';

spl_autoload_register(function($class){
	$root = dirname(__DIR__); //get the parent directory
	$file = $root . '/' .str_replace('\\', '/', $class) . '.php';
	if(is_readable($file)) {
		require $root . '/' . str_replace('\\', '/', $class). '.php';
	}
});

$router = new Core\Router();
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
// echo '<pre>';
// var_dump($router->getRoutes());
// echo '</pre>';

//Match the requested URL
/*
$url = $_SERVER['QUERY_STRING'];
if($router->match($url)){
	echo '<pre>';
	var_dump($router->getParams());
	echo htmlspecialchars(print_r($router->getRoutes(), true));
	echo '</pre>';
}else {
	echo "No route found for url '$url'";
}*/

$router->dispatch($_SERVER['QUERY_STRING']);