<?php

namespace App\Controllers\Admin;
use \Core\Controller as BaseController;

class Users extends BaseController
{
	/**
	 * Before filter
	 * @return void
	 */
	protected function before()
	{
		//Make sure an admin user is logged in
		//return false;
	}

	public function indexAction()
	{
		echo 'User Admin index';
	}
}