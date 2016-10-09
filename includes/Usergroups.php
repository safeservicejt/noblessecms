<?php

class Usergroups
{
	public static $groups=array();

	public static function get($inputData=array())
	{
		Table::setTable('usergroups');

		Table::setFields('id,title,permissions,date_added');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 


				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}

				if(isset($rows[$i]['permissions']))
				{
					$rows[$i]['permissions_array']=self::lineToArray($rows[$i]['permissions']);
				}



			}

			return $rows;

		});

		return $result;
	}

	public static function getPermission($groupid,$keyName='',$keyVal=false)
	{
		$loadData=array();

		if(isset(self::$groups[$groupid]))
		{
			$loadData=self::$groups[$groupid];
		}
		else
		{
			$load=self::loadCache($groupid);

			$loadData=$load['permissions_array'];

			self::$groups[$groupid]=$loadData;
		}

		$result=isset($loadData[$keyName])?$loadData[$keyName]:$keyVal;

		return $result;
	}

	public static function changePermissionAll($updateData=array())
	{
		$loadData=self::get(array(
			'cache'=>'no',
			));

		$total=count($loadData);

		for ($i=0; $i < $total; $i++) { 
			$id=$loadData[$i]['id'];

			self::changePermission($id,$updateData);
		}
	}

	public static function changePermission($groupid,$updateData=array())
	{
		if(!is_array($updateData))
		{
			return false;
		}

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$groupid'"
			));

		if(!$loadData || !isset($loadData[0]['id']))
		{
			return false;
		}

		$total=count($updateData);

		$keyList=array_keys($updateData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyList[$i];

			$loadData[0]['permissions_array'][$keyName]=$updateData[$keyName];
		}

		$permissions=self::arrayToLine($loadData[0]['permissions_array']);

		self::update($groupid,array(
			'permissions'=>$permissions
			));

		self::saveCache($groupid);
	}

	public static function insert($inputData=array())
	{
		Table::setTable('usergroups');

		$result=Table::insert($inputData,function($insertData){
			if(!isset($insertData['date_added']))
			{
				$insertData['date_added']=date('Y-m-d H:i:s');
			}

			return $insertData;
		},function($inputData){
			if(isset($inputData['id']))
			{
				Usergroups::saveCache($inputData['id']);
			}
		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('usergroups');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			if(isset($inputData['content']))
			{
				$inputData['content']=addslashes($inputData['content']);
			}

			return $inputData;
		});

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('usergroups');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}

	public static function lineToArray($inputData='')
	{
		if(preg_match_all('/(\w+)[\:\|](\w+)/is', $inputData, $matches))
		{
			$inputData=array();

			$total=count($matches[1]);

			for ($i=0; $i < $total; $i++) { 
				$keyName=$matches[1][$i];

				$keyVal=$matches[2][$i];

				$inputData[$keyName]=$keyVal;
			}
		}

		return $inputData;
	}

	public static function arrayToLine($inputData=array())
	{
		$total=count($inputData);

		$keyList=array_keys($inputData);

		$li='';

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyList[$i];

			$li.=$keyName.'|'.$inputData[$keyName]."\r\n";
		}

		return $li;
	}

	public static function loadCache($id)
	{
		Table::setTable('usergroups');

		$result=Table::loadCache($id,function($id){
			Usergroups::saveCache($id);
		});

		if(isset($result['permissions']) && !isset($result['permissions_array']))
		{
			$result['permissions_array']=self::lineToArray($result['permissions']);
		}

		return $result;

	}

	public static function removeCache($id)
	{
		Table::setTable('usergroups');

		Table::removeCache($id);

	}

	public static function saveCache($id)
	{
		Table::setTable('usergroups');

		Table::saveCache($id);
	}

	public static function saveCacheAll()
	{
		$savePath=ROOT_PATH.'caches/system/usergroups/';

		$loadData=array();

		$loadData=self::get(array(
				'cache'=>'no',
				'selectFields'=>'*',
				'where'=>"where id='$id'"
				));	

		if(isset($loadData[0]['id']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$filePath=$savePath.$loadData[$i]['id'].'.cache';

				File::create($filePath,serialize($loadData[$i]));
			}
			
		}
		
	}

}