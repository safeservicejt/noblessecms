<?php

/*
	$run=new Controllers();

	$run->load('dashboard','index','applicaton/');
*/


class Controllers
{
	public static $loadPath = '';

	public static function load($controlName = '', $funcName = 'index',$loadPath='')
	{
		self::$loadPath=ROOT_PATH.$loadPath;

		// $controlName=ucfirst($controlName);

		$realControlname='control'.$controlName;

		$filePath=self::$loadPath.'/controllers/control'.$controlName.'.php';

		$funcName=isset($funcName[1])?$funcName:'index';

		if(!file_exists($filePath))
		{
			Alert::make('Controller '.$controlName.' not exists in '.self::$loadPath.'/controllers/');
		}

		include($filePath);

		if(!class_exists($realControlname))
		{
			Alert::make('Class '.$realControlname.' not exists in '.$filePath);
		}

		if(!method_exists($realControlname, $funcName))
		{
			Alert::make('Method '.$funcName.' not exists in controller '.$realControlname);
		}

		$modelName=strtolower($controlName);

		$modelPath=self::$loadPath.'/models/'.$modelName.'.php';

		if(!file_exists($modelPath))
		{
			Alert::make('Model '.$controlName.' not exists in '.self::$loadPath.'/models/');
		}

		include($modelPath);



		$realControlname::$funcName();
	}

	


}