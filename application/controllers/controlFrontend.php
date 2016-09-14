<?php

class controlFrontend
{
	public static function index()
	{
		self::before_frontend_start();

		$controlName='home';

		if($match=Uri::match('^\/?(\w+)'))
		{
			$controlName=$match[1];
		}

		$themeName=System::$setting['theme_name'];

		$themePath=THEMES_PATH.$themeName.'/';	

		Theme::loadSetting($themeName);

		if(file_exists($themePath.'index.php'))
		{
			include($themePath.'index.php');
		}

		Controllers::load(ucfirst($controlName),'index','contents/themes/'.$themeName);

	}

	public static function before_frontend_start()
	{
		ob_start('sanitize_output');
		
		// Load plugins
		Plugins::load('before_frontend_start');

		// Load shortcode
		Shortcode::load();


	}
}
