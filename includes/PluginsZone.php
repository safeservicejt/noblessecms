<?php

class PluginsZone
{
	public function get()
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

	public function loadCache()
	{
		if(!$loadData=Cache::loadKey('listZones',-1))
		{
			return false;
		}
		
		Plugins::$listCaches=unserialize($loadData);

		// print_r(Plugins::$listCaches);die();
	}

	public function addCache($zoneName,$inputData=array())
	{
		Plugins::$listCaches[$zoneName][]=$inputData;

		self::saveCache();		
	}

	public function removeCache($foldername)
	{
		$listKey=array_keys(Plugins::$listCaches);

		$totalKey=count($listKey);

		for ($i=0; $i < $totalKey; $i++) { 
			$theKey=$listKey[$i];

			$total=count(Plugins::$listCaches[$theKey]);

			for ($j=0; $j < $total; $j++) { 
				if(Plugins::$listCaches[$theKey][$j]['foldername']==$foldername)
				{
					unset(Plugins::$listCaches[$theKey][$j]);
				}
			}

			sort(Plugins::$listCaches[$theKey]);
		}

		// print_r(Plugins::$listCaches);die();

		self::saveCache();	
	}

	public function addPlugin($zonename,$inputData)
	{

		if(!isset($inputData['status']) || (int)$inputData['status']==0)
		{
			return false;
		}

		$loadData=array();

		if($loadData=Cache::loadKey('listZones',-1))
		{
			$loadData=unserialize($loadData);
		}		

		$loadData[$zonename]=$inputData;

		Plugins::$listCaches=$loadData;

		self::saveCache();

	}

	public function saveCache()
	{
		$loadData=PluginsMeta::get(array(
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

			Cache::saveKey('listZones',serialize($resultData));	

			return $resultData;
		}
		else
		{
			Cache::removeKey('listZones');
		}
	}


}

?>