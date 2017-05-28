<?php

namespace Core;

abstract class Controller
{
	/**
	 * Parameters from the matched route
	 * @var array
	 */
	protected $route_params = [];
}