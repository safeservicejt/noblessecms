<?php

/*
	Layouts have to exists in folder's theme

	Struct

	themeFolder/layouts/layoutname_1/controllers+models+views

*/

class Layout
{
	public static $config=array();

	public static $isLoaded='no';

	public static function make($themeName='',$layoutName='default',$inputData=array())
	{
		$themeName=!isset($themeName[1])?THEME_NAME:$themeName;

		$themePath=THEMES_PATH.$themeName.'/';

		$layoutPath=$themePath.'layouts/'.$layoutName.'/';

		if(!is_dir($layoutPath.'controllers/') || !is_dir($layoutPath.'controllers/') || !is_dir($layoutPath.'controllers/'))
		{
			throw new Exception('Layouts struct not valid in path: '.$layoutPath);
		}

		$inputData['home']=!isset($inputData['home'])?'themeHome':$inputData['home'];

		if(!preg_match('/^theme\w+/i', $inputData['home']))
		{
			$inputData['home']='theme'.ucfirst($inputData['home']);
		}

		$listKeys=array_keys($inputData);

		$total=count($listKeys);

		if($total > 0)
		{
			$listVal=array_values($inputData);

			for ($i=0; $i < $total; $i++) { 
				$theKey=$listKeys[$i];

				if(!preg_match('/^theme\w+/i', $theKey))
				{
					$inputData[$theKey]='theme'.ucfirst($theKey);
				}

			}
		}

		$loadData='';

		if(!$loadData=Cache::loadKey('layouts',-1))
		{
			$loadData=array();
		}
		else
		{
			$loadData=unserialize($loadData);
		}

		$loadData[$layoutName]=$inputData;

		Cache::saveKey('layouts',serialize($loadData));
	}

	public static function load($layoutName='')
	{
		$loadData=array();

		if(!$loadData=Cache::loadKey('layouts',-1))
		{
			$loadData=array();
		}	
		else
		{
			self::$config=unserialize($loadData);


		}	

		if(isset($layoutName[1]))
		{
			Theme::$layoutPath='layouts/'.$layoutName.'/';
		}		

		self::$isLoaded='yes';
	}

	public static function get($layoutName='default',$keyName='home',$defaultVal='homeView')
	{
		if(self::$isLoaded!='yes')
		{
			self::load();
		}

		if(isset(self::$config[$layoutName]) && isset(self::$config[$layoutName][$keyName]))
		{
			$defaultVal=self::$config[$layoutName][$keyName];
		}

		return $defaultVal;
	}

	public static function remove($layoutName)
	{
		if(self::$isLoaded!='yes')
		{
			self::load();
		}

		if(isset(self::$config[$layoutName]))
		{
			unset(self::$config[$layoutName]);
		}

		self::save();
	}

	public static function save()
	{
		if(self::$isLoaded!='yes')
		{
			return false;
		}		

		Cache::saveKey('layouts',serialize(self::$config));
	}


	public static function getDirs($themeName='')
	{
		$themeName=!isset($themeName[1])?THEME_NAME:$themeName;

		$themePath=THEMES_PATH.$themeName.'/';

		$layoutPath=$themePath.'layouts/';

		$loadData=array();

		$loadData=Dir::allDir($layoutPath);

		return $loadData;		
	}
}