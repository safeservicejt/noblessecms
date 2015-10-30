<?php

class controlFrontEnd
{
	public function index()
	{
		CustomPlugins::load('before_frontend_start');

		System::systemStatus();

		// if($match=Uri::match('^(\w+)$'))
		// {
		// 	echo $match[1];
		// }

		$themePath=System::getThemePath();

		$indexPath=$themePath.'index.php';

		if(file_exists($indexPath))
		{
			Theme::checkDomain();
			
			Theme::checkThemePrefix();

			Theme::loadShortCode();

			include($indexPath);
		}
		else
		{
			Alert::make('Theme not found');
		}

		CustomPlugins::load('after_frontend_start');


	}
}

?>