<?php

class PluginMetas
{
	public static $listZone=array();

	public static function get($inputData=array())
	{
		Table::setTable('pluginmetas');

		Table::setFields('id,foldername,status,zonename,sort_order,type,funcname,classname,filepath');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array(),$beforeInsert='',$afterInsert='')
	{
		Table::setTable('pluginmetas');

		$result=Table::insert($inputData,$beforeInsert,$afterInsert);

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('pluginmetas');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('pluginmetas');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		$savePath=ROOT_PATH.'caches/system/pluginmetas/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			return false;			
		}

		return true;
	}

	public static function loadCache($id)
	{
		$savePath=ROOT_PATH.'caches/system/pluginmetas/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function saveCache($id,$inputData=array())
	{
		if((int)$id==0)
		{
			return false;
		}

		$savePath=ROOT_PATH.'caches/system/pluginmetas/'.$id.'.cache';

		$loadData=array();

		$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where id='$id'"
				));	

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData[0]));
		}
		
	}

	public static function loadCacheAll()
	{
		$savePath=ROOT_PATH.'caches/system/pluginZoneList.cache';

		if(!file_exists($savePath))
		{
			self::saveCacheAll();

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=file_get_contents($savePath);

		if(isset($loadData[10]))
		{
			$loadData=unserialize($loadData);

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				
				$zonename=$loadData[$i]['zonename'];

				self::$listZone[$zonename][]=$loadData[$i];

			}			
		}


		return $loadData;

	}

	public static function saveCacheAll()
	{

		$savePath=ROOT_PATH.'caches/system/pluginZoneList.cache';

		$loadData=array();

		$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where status='1'"
				));	

		if(!isset($loadData[0]['id']))
		{
			$loadData=array();
		}

		File::create($savePath,serialize($loadData));
		
	}	
}