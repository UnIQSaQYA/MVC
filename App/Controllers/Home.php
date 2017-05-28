<?php

namespace App\Controllers;
use \Core\Controller as BaseController;
use \Core\View;

class Home extends BaseController
{
	/**
	 * Before filter
	 * @return void
	 */
	protected function before()
	{
		echo "(before) ";
		return false;
	}

	/**
	 * After filter
	 * @return void
	 */
	protected function after()
	{
		echo " (after)";
	}

	public function index()
	{
		// View::render('Home/index.php', [
		// 	'name'	=> 'Niklesh',
		// 	'colours'=> ['red', 'blue', 'green']
		// ]);
		View::renderTemplate('Home/index.html', [
			'name'	=> 'Niklesh',
			'colours'=> ['red', 'blue', 'green']
		]);
	}
}