<?php

namespace App\Controllers;
use Core\Controller as BaseController;

class Posts extends BaseController
{
	/**
	 * Show the index page
	 * return void
	 */
	
	public function indexAction()
	{
		echo 'Hello world!';
		echo '<pre>'.htmlspecialchars(print_r($_GET, true)).'</pre>';
	}

	public function addNewAction()
	{
		echo 'add new';
	}

	public function editAction()
	{
		echo 'Hello world!';
		echo '<pre>'.htmlspecialchars(print_r($this->route_params, true)).'</pre>';
	}

}