<?php

class PluginsApi
{

	public static function get($foldername)
	{
		if(!$match=Uri::match($foldername.'\/(\w+)'))
		{
			throw new Exception("Not match valid route.");
		}

		$routeName=$match[1];

		$pluginPath=PLUGINS_PATH.$foldername.'/api.php';

		define("THIS_URL",PLUGINS_URL.$foldername.'/');

		define("THIS_PATH",PLUGINS_PATH.$foldername.'/');

		if(!file_exists($pluginPath))
		{
			return false;
		}

		include($pluginPath);

		$routes=SelfApi::route();

		if(!isset($routes[$routeName]))
		{
			throw new Exception("Plugin not support this route.");
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