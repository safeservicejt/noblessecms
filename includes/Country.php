<?php

class Country
{
	public static function get($inputData=array())
	{
		Table::setTable('country');

		Table::setFields('id,name,iso_code_2,iso_code_3');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array(),$beforeInsert='',$afterInsert='')
	{
		Table::setTable('country');

		$result=Table::insert($inputData,$beforeInsert,$afterInsert);

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('country');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('country');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function loadCache()
	{
		$savePath=ROOT_PATH.'caches/system/countriesList.cache';

		if(!file_exists($savePath))
		{
			self::saveCache();

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function saveCache($inputData=array())
	{
		$savePath=ROOT_PATH.'caches/system/countriesList.cache';

		$loadData=array();

		$loadData=self::get(array(
			'cache'=>'no',
			));	

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData));
		}
		
	}


	public static function makeSelect()
	{
		$loadData=self::loadCache();

		$total=count($loadData);

		$li='';

		if(isset($loadData[0]['name']))
		for ($i=0; $i < $total; $i++) { 
			$li.='<option value="'.$loadData[$i]['iso_code_2'].'">'.$loadData[$i]['name'].'</option>';
		}

		return $li;
	}	
}