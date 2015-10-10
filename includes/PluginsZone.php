<?php

class PluginsZone
{
	public static function get()
	{
		if(isset(Plugins::$listCaches['loaded']))
		{
			if(!self::loadCache())
			{
				return false;
			}
		}



		return Plugins::$listCaches;
	}

	public static function loadCache()
	{
		
		$filePath=self::cachePath();

		if(!file_exists($filePath))
		{
			return false;
		}

		$loadData=unserialize(file_get_contents($filePath));
		
		Plugins::$listCaches=$loadData;
	}

	public static function addCache($zoneName,$inputData=array())
	{
		Plugins::$listCaches[$zoneName][]=$inputData;

		self::saveCache();		
	}

	public static function removeCache($foldername)
	{
		if(isset(Plugins::$listCaches['loaded']) && Plugins::$listCaches['loaded']=='no')
		{
			self::loadCache();
		}

		$listKey=array_keys(Plugins::$listCaches);

		$totalKey=count($listKey);

		for ($i=0; $i < $totalKey; $i++) { 
			$theKey=$listKey[$i];

			$total=count(Plugins::$listCaches[$theKey]);

			for ($j=0; $j < $total; $j++) { 

				if(!isset(Plugins::$listCaches[$theKey][$j]['foldername']))
				{
					continue;
				}

				if(Plugins::$listCaches[$theKey][$j]['foldername']==$foldername)
				{
					unset(Plugins::$listCaches[$theKey][$j]);
				}
			}

			if(is_array(Plugins::$listCaches[$theKey]))
			{
				sort(Plugins::$listCaches[$theKey]);
			}
			
		}


		self::saveCache();	
	}

	public static function addPlugin($zonename,$inputData)
	{

		if(!isset($inputData['status']) || (int)$inputData['status']==0)
		{
			return false;
		}

		$loadData=array();

		$filePath=self::cachePath();

		if(file_exists($filePath))
		{
			$loadData=unserialize(file_get_contents($filePath));
		}	

		$loadData[$zonename]=$inputData;

		Plugins::$listCaches=$loadData;

		self::saveCache();

	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/listZones'.Database::getPrefix().'.cache';

		return $result;
	}

	public static function saveCache()
	{
		$loadData=PluginsMeta::get(array(
			'cache'=>'no',
			'cacheTime'=>1,
			'where'=>"where status='1'",
			'orderby'=>"order by zonename asc"
			));

		$resultData=array();

		// print_r($loadData);die();

		if(isset($loadData[0]['zonename']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$theZone=$loadData[$i]['zonename'];

				$resultData[$theZone][]=$loadData[$i];

				
			}

			$filePath=ROOT_PATH.'application/caches/listZones'.Database::getPrefix().'.cache';

			File::create($filePath,serialize($resultData));

			return $resultData;
		}
		else
		{
			Cache::removeKey('listZones');
		}
	}


}

?>