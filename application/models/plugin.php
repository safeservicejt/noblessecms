<?php

function apiProcess($folderName='')
{
	if(!$match=Uri::match($folderName.'\/(\w+)'))
	{
		throw new Exception("Not match valid route.");
	}

	$routeName=$match[1];

	$themePath=THEMES_PATH.$folderName.'/';

	$filePath=$themePath.'api.php';

	$result='';

	if(file_exists($filePath))
	{
		include($filePath);

		if(!class_exists('SelfApi'))
		{
			throw new Exception('Class SelfApi not exist at '.$filePath);
			
		}

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
	else
	{
		throw new Exception('We not support api ');
	}
}