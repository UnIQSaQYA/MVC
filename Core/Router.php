<?php

namespace Core;

class Router
{
	/**
	 * Associative array of routes
	 * @var array
	 */
	protected $routes = [];

	/**
	 * Parameters from the matched route
	 * @var array
	 */
	protected $params = [];
	/**
	 * Add a route to the routing table
	 * @param [type] $route  The route url
	 * @param [type] $params Parameters (Controller, action, etc.)
	 */
	public function add($route, $params = [])
	{
		//Convert the route to a regular expression: escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);

		//convert variables e.g {controller}
		$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

		//convert variables with custom regular expressions e.g. {id:\d+}
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
		//Add start and end delimeters, and case insensitive flag
		$route = '/^' . $route . '$/i'; 
		$this->routes[$route] = $params;
	}

	/**
	 * Get all the routes from routing table
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Match the route to the routes in the routing table, setting the $params
	 * property if a route is found
	 * 
	 * @param  [type] $url The route $url
	 * @return [type] boolean true if a match found, false otherwise
	 **/
	public function match($url)
	{
		foreach($this->routes as $route => $params) {
			if(preg_match($route, $url, $matches)) {
				foreach ($matches as $key => $match) {
					if(is_string($key)) {
						$params[$key] = $match;
					}
				}
				$this->params = $params;
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the currently matched parameter `
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * Dispatch the route, creating the controller objects and running the
	 * action method
	 * 
	 * @param  $string $url The route url 
	 * @return void	 
	 * */
	public function dispatch($url)
	{
		$url = $this->removeQueryStringVariables($url);
		if($this->match($url)) {
			$controller = $this->params['controller'];
			$controller = $this->convertToStudlyCaps($controller);
			// $controller = "App\Controllers\\$controller";
			$controller = $this->getNamespace() . $controller;
			if(class_exists($controller)) {
				$controller_object = new $controller($this->params);

				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);

				if(is_callable([$controller_object, $action])) {
					$controller_object->$action();
				}else {
					echo "Method $action (in controller $controller) not found";
				}
			}else {
				echo "Controller class $controller not found";
			}
		}else {
			echo "No route found.";
		}
	}

	/**
	 * convert the string with hyphens to StudlyCaps,
	 * e.g. post-authors => PostAuthors
	 * 
	 * @param  string $string The string to convert
	 * @return string         The converted string
	 */
	public function convertToStudlyCaps($string)
	{
		return str_replace(' ', '',  ucwords(str_replace('-', ' ', $string)));
	}

	/**
	 * convert the string with hyphons to camel case,
	 * e.g. add-new => addNew
	 *  
	 * @param  string $string the converted the string
	 * @return $string
	 */
	public function convertToCamelCase($string)
	{
		return lcfirst($this->convertToStudlyCaps($string));
	}

	/**
	 * Remove the query string variables from the URL (if any). As the full
	 * query string is used for the route, any variables at the end will need
	 * to be removed before the route is matched to the routing table. For example
	 * 
	 * URL                                  $_SERVER['QUERY_STRING']       ROUTE
	 * ----------------------------------------------------------------------------
	 * localhost							''							   ''
	 * localhost/?							''							   ''
	 * localhost/?page=1					page=1						   ''
	 * localhost/posts?page=1				posts&page=1				   posts
	 * localhost/posts/index      		    post/index  				   posts/index
	 * localhost/posts/index?page=1         posts/index&page=1             posts/index
	 * 
	 * A URL of the format localhost/?page (one variablename. no value) won't work however.
	 * (NB. The .htaccessfile converts the first ? to a & when it's passed through a $_SERVER
	 * variable)
	 * 
	 * @param  string $url The full url
	 * @return string      The url with the query string variables removed
	 */
	
	protected function removeQueryStringVariables($url) {
		if($url != '') {
			$parts = explode('&', $url, 2);
			if(strpos($parts[0], '=') === false) {
				$url = $parts[0];
			}else {
				$url = '';
			}
		}
		return $url;
	}

	protected function getNamespace()
	{
		$namespace = 'App\Controllers\\';

		if(array_key_exists('namespace', $this->params)) {
			$namespace .= $this->params['namespace'] . '\\';
		}
		return $namespace;
	}
}