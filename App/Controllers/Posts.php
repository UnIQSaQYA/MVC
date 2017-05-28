<?php

namespace App\Controllers;

class Posts
{
	/**
	 * Show the index page
	 * return void
	 */
	
	public function index()
	{
		echo 'Hello world!';
		echo '<pre>'.htmlspecialchars(print_r($_GET, true)).'</pre>';
	}

	public function addNew()
	{
		echo 'add new';
	}
}