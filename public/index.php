<?php

//echo 'Requested URL ="' . $_SERVER['QUERY_STRING'] .'"';


require '../Core/Router.php';
$router = new Router();
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
// echo '<pre>';
// var_dump($router->getRoutes());
// echo '</pre>';

//Match the requested URL

$url = $_SERVER['QUERY_STRING'];
if($router->match($url)){
	echo '<pre>';
	var_dump($router->getParams());
	echo htmlspecialchars(print_r($router->getRoutes(), true));
	echo '</pre>';
}else {
	echo "No route found for url '$url'";
}