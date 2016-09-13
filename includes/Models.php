<?php

class Models
{
	public static function load($keyName='')
	{
		$mvcPath='';

		$data=debug_backtrace();  

		$mvcPath=dirname(dirname($data[0]['file'])).'/';

		$modelPath=$mvcPath.'models/';

		$filePath=$modelPath.$keyName.'.php';

		if(!is_dir($modelPath))
		{
			Alert::make('Model '.$keyName.' not exists in '.$modelPath);
		}

		if(!file_exists($filePath))
		{
			Alert::make('File not exists in '.$filePath);
		}		

		include($filePath);

	}
}