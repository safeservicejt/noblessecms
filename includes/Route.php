<?php

/*

Place below function in index.php file of plugin which you wanna add route

Route::get('admincp\/post',function(){
	echo 'ok adminc post';

});


Route::get('admincp',function(){
	echo 'ok admin';

});


Route::get('',function(){
	echo 'ok usercp';

});

*/
class Route
{


	public static function get($keyName='',$controllerName)
	{
		$curUri=System::getUri();

		$curUri=($curUri=='/')?'':$curUri;

		// $keyName = str_replace('/', '\/', $keyName);

		if($keyName!='' && !preg_match('/'.$keyName.'/i', $curUri))
		{
			return false;
		}

		// $data=debug_backtrace();  

		// $fileCall=basename($data[0]['file']);		

		// $subUri=basename($curUri);

		// $lastUri=dirname($curUri);

		// if(preg_match('/^(\w+)\//i', $curUri,$match))
		// {
		// 	// print_r($curUri);
		// 	if($keyName!=$match[1] && !preg_match('/^[a-zA-Z0-9_\-\_\/]+\/'.$keyName.'/i', $curUri))
		// 	{
		// 		return false;
		// 	}			

		// }
		// else
		// {
		// 	if(!preg_match('/^'.$keyName.'/i', $curUri))
		// 	{
		// 		return false;
		// 	}
			
		// }


		// admincp/post != admincp/categories
		


		if(is_object($controllerName))
		{
			$controllerName=(object)$controllerName;
			
			$controllerName();	

			System::after_system_start();

			die();
		}
		else
		{
			$funcName='index';

			$controlPath=ROOT_PATH;

			if(preg_match('/^([a-zA-Z0-9_\-\_\/]+)\/(\w+)$/i', $controllerName,$matchPath))
			{
				$controlPath=$matchPath[1];

				$controllerName=$matchPath[2];

				$funcName='index';
			}

			if(preg_match('/(.*?)\@(.*?)/i', $controllerName,$match))
			{
				if(preg_match('/^([a-zA-Z0-9_\-\_\/]+)\/(\w+)$/i', $match[1],$matchPath))
				{
					$controlPath=$matchPath[1];

					$controllerName=$matchPath[2];
				}

				$funcName=$match[2];
			}

			Controllers::load($controllerName,$funcName,$controlPath);

			System::after_system_start();

			die();
		}

	}

}