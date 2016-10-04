<?php

class Alert
{
	public static function make($inputData='')
	{
		$notFoundPath=System::getThemePath().'controllers/control404page.php';

		if(System::$setting['system_mode']!='debug' && file_exists($notFoundPath))
		{
			Redirects::to('404page');
		}

        ob_end_clean();

       	Response::headerCode(404);

       	include(ROOT_PATH.'contents/system/alert/alert.php');

       	die();
	}
}