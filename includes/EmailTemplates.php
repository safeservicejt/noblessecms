<?php

class EmailTemplates
{
	public static function get($inputData=array())
	{
		Table::setTable('email_templates');

		Table::setFields('id,subject,content,date_added');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array(),$beforeInsert='',$afterInsert='')
	{
		Table::setTable('email_templates');

		$result=Table::insert($inputData,$beforeInsert,$afterInsert);

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('email_templates');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('email_templates');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		$savePath=ROOT_PATH.'caches/system/emailtemplate/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			return false;			
		}

		return true;
	}

	public static function loadCache($id)
	{
		$savePath=ROOT_PATH.'caches/system/emailtemplate/'.$id.'.cache';

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

		$savePath=ROOT_PATH.'caches/system/emailtemplate/'.$id.'.cache';

		$loadData=array();

		if(isset($inputData['id']))
		{
			$loadData=array();

			$loadData[0]=$inputData;
		}
		else
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where id='$id'"
				));	

		}

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData[0]));
		}
		
	}
}