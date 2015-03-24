<?php

class frontend
{
	public function index()
	{
		GlobalCMS::mainStatus();

		Plugins::load('before_system_load');

		Theme::loadShortCode();

		SpecialPages::load();

		View::themeMake('index');

		Plugins::load('after_system_load');


		

		// include(THEME_PATH.'index.php');
		
	}
}



?>