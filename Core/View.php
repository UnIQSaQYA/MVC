<?php

namespace Core;

class View
{

	/**
	 * Render a view file
	 * @param  string $view The View file
	 * @return void
	 */
	public static function render($view, $args = [])
	{
		extract($args, EXTR_SKIP);
		$file = "../App/Views/$view"; //relative to core directory
		
		if(is_readable($file)) {
			require $file;
		}else {
			echo "$fle not found";
		}
	}

	/**
	 * Render Twig template
	 * @param  string $view The View file
	 * @return void
	 */
	public static function renderTemplate($template, $args = [])
	{
		static $twig = null;

		if($twig === null) {
			$loader = new \Twig_Loader_Filesystem('../App/Views');
			$twig = new \Twig_Environment($loader);
		}
		echo $twig->render($template, $args);
	}
}