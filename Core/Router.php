<?php

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
	 */
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
}