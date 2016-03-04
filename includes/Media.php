<?php

class Media
{
	public static function api($action)
	{
		$route=array(
			'load_file'=>'loadFile',
			'load_dir'=>'loadDir',

			);

		if(!isset($route[$action]) || !method_exists('Media', $route[$action]))
		{
			throw new Exception('We not support this action.');
		}

		$methodName=$route[$action];

		try {
			$result=self::$methodName();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}	

	public static function loadDir()
	{
		$send_path=trim(Request::get('send_path',''));

		if($send_path==ROOT_PATH)
		{
			throw new Exception('We not allow to view this dir.');
		}

		$allDir=Dir::all($send_path);

		if(in_array('includes', $allDir) && in_array('routes.php', $allDir) && in_array('config.php', $allDir))
		{
			throw new Exception('We not allow to view this dir.');
		}	
		
			
	}


}

?>