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

		define("THIS_URL",ROOT_URL.'contents/themes/'.$foldername.'/');

		define("THIS_PATH",ROOT_PATH.'contents/themes/'.$foldername.'/');		

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

		if(!method_exists('SelfApi', $func))
		{
			throw new Exception('Route '.$routeName.' not ready for runc.');
		}

		try {
			$result=SelfApi::$func();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}
}
?>