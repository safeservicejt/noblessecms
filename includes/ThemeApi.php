<?php

class ThemeApi
{

	public function get($foldername)
	{
		if(!$match=Uri::match($foldername.'\/(\w+)'))
		{
			throw new Exception("Not match valid route.");
		}

		$routeName=$match[1];

		$pluginPath=ROOT_PATH.'contents/themes/'.$foldername.'/api.php';

		if(!file_exists($pluginPath))
		{
			return false;
		}

		include($pluginPath);

		$routes=SelfApi::route();

		if(!isset($routes[$routeName]))
		{
			throw new Exception("Theme not support this route.");
		}

		$func=$routes[$routeName];

		$result=SelfApi::$func();

		return $result;
	}
}
?>