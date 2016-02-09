<?php

class controlFrontEnd
{
	public function index()
	{
		function sanitize_output($buffer) {

		    $search = array(
		        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
		        '/(\s)+/s'       // shorten multiple whitespace sequences
		    );

		    $replace = array(
		        '>',
		        '<',
		        '\\1'
		    );

		    $buffer = preg_replace($search, $replace, $buffer);

		    return $buffer;
		}

		ob_start('sanitize_output');		
		
		CustomPlugins::load('before_frontend_start');

		System::systemStatus();

		// if($match=Uri::match('^(\w+)$'))
		// {
		// 	echo $match[1];
		// }

		Widgets::loadCache();

		$themePath=System::getThemePath();

		$indexPath=$themePath.'index.php';

		if(file_exists($indexPath))
		{
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