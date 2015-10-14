<?php
/*
	CustomPlugins::add('before_create_code',array(
		'method_call'=>'func',
		'path'=>'contents/plugins/calltocode/index.php',
		'func'=>'calltocode_creatcode'
		));

	CustomPlugins::load('before_create_code');

	CustomPlugins::removeByPath('calltocode');
*/
class CustomPlugins
{
	public static $listCaches=array('loaded'=>'no');

	public static $canInstall='no';

	public static $canUninstall='no';

	public static $canAddZone='no';


	public static function add($zoneName='',$inputData=array())
	{
		/*

		$inputData:

		method_call: class|func

		path: path of included file

		func: name of function will call
	
		class: name of class will call

		Default method of class is 'index'

		All function, method require inputData=array();

		*/


		$inputData['method_call']=isset($inputData['method_call'])?$inputData['method_call']:'func';

		$inputData['class']=isset($inputData['class'])?$inputData['class']:'';

		if(!isset($inputData['path']))
		{
			return false;
		}

		$inputData['func']=isset($inputData['func'])?$inputData['func']:'index';

		$inputData['path']=str_replace(ROOT_PATH, '', $inputData['path']);

		$filePath=self::cachePath();

		$loadData=array();

		if(file_exists($filePath))
		{
			$loadData=unserialize(file_get_contents($filePath));
		}

		if(isset($loadData[$zoneName][0]['path']))
		{
			$total=count($loadData[$zoneName]);

			for ($i=0; $i < $total; $i++) { 
				if($loadData[$zoneName][$i]['path']==$inputData['path'] && $loadData[$zoneName][$i]['func']==$inputData['func'] && $loadData[$zoneName][$i]['method_call']==$inputData['method_call'] && $loadData[$zoneName][$i]['class']==$inputData['class'] )
				{
					return false;
				}
			}
		}

		$loadData[$zoneName][]=$inputData;

		unset($loadData['loaded']);

		unset(self::$listCaches['loaded']);

		self::$listCaches=$loadData;
		self::saveCache();		
	}

	public static function loadCache()
	{
		if(!isset(self::$listCaches['loaded']))
		{
			return false;
		}

		$filePath=self::cachePath();

		$loadData=array();

		if(file_exists($filePath))
		{
			$loadData=unserialize(file_get_contents($filePath));
		}

		unset(self::$listCaches['loaded']);

		self::$listCaches=$loadData;		
	}

	public static function remove($zoneName='')
	{
		if(isset($zoneName[1]))
		{
			return false;
		}

		if(isset(self::$listCaches['loaded']))
		{
			return false;
		}

		self::loadCache();

		unset(self::$listCaches[$zoneName]);

		self::saveCache();

	}

	public static function removeByPath($foldername='')
	{
		if(!isset($foldername[1]))
		{
			return false;
		}
		
		if(isset(self::$listCaches['loaded']))
		{
			self::loadCache();
		}

		if(isset(self::$listCaches['loaded']))
		{
			return false;
		}

		$total=count(self::$listCaches);

		$keyNames=array_keys(self::$listCaches);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			if(!isset(self::$listCaches[$keyName][0]['path']))
			{
				continue;
			}

			$totalCall=count(self::$listCaches[$keyName]);

			for ($j=0; $j < $totalCall; $j++) { 

				if(!isset(self::$listCaches[$keyName][$j]))
				{
					continue;
				}

				if(preg_match('/\/'.$foldername.'\//i', self::$listCaches[$keyName][$j]['path']))
				{
					unset(self::$listCaches[$keyName][$j]);
				}
			}

			sort(self::$listCaches[$keyName]);
		}

		self::saveCache();
	}

	public static function load($zoneName='',$inputData=array())
	{
		if(!isset(self::$listCaches[$zoneName]))
		{
			self::loadCache();
		}

		if(!isset(self::$listCaches[$zoneName]))
		{
			return false;
		}

		$total=count(self::$listCaches[$zoneName]);

		$li='';

		for ($i=0; $i < $total; $i++) { 

			if(!isset(self::$listCaches[$zoneName][$i]))
			{
				continue;
			}

			$row=self::$listCaches[$zoneName][$i];

			$method_call=$row['method_call'];

			$filePath=ROOT_PATH.$row['path'];

			if(!file_exists($filePath))
			{
				continue;
			}

			if($method_call=='func')
			{
				if(!function_exists($row['func']))
				{
					include($filePath);
				}

				$func=$row['func'];
				try {
					$li.=$func($inputData);
				} catch (Exception $e) {
					throw new Exception($e->getMessage());
					
				}
				
			}

			if($method_call=='class')
			{
				if(!class_exists($row['class']))
				{
					include($filePath);
				}

				$class=$row['class'];

				$func=isset($row['func'])?$row['func']:'index';

				try {
					$li.=$class::$func($inputData);
				} catch (Exception $e) {
					throw new Exception($e->getMessage());
					
				}
			}

		}

		return $li;

	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/customPlugins'.Database::getPrefix().'.cache';

		return $result;
	}

	public static function saveCache()
	{
		$loadData=self::$listCaches;

		$filePath=self::cachePath();

		File::create($filePath,serialize($loadData));
	}
}

?>