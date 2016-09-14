<?php

class Vouchers
{
	public static function get($inputData=array())
	{
		Table::setTable('vouchers');

		Table::setFields('id,date_added,date_expires,date_start,status,code,money');

		$result=Table::get($inputData);

		return $result;
	}

	public static function exists($code='')
	{
		$fileName=String::makeFriendlyUrl(strip_tags($code));

		$savePath=ROOT_PATH.'contents/fastecommerce/coupon/'.$fileName.'.cache';

		$result=true;

		if(!file_exists($savePath))
		{
			$result=false;
		}

		return $result;
	}

	public static function loadCache($code='')
	{
		$fileName=String::makeFriendlyUrl(strip_tags($code));

		$savePath=ROOT_PATH.'contents/fastecommerce/coupon/'.$fileName.'.cache';

		$result=false;

		if(!file_exists($savePath))
		{
			
			self::saveCache();

			if(!file_exists($savePath))
			{
				return false;
			}
		}

		$result=unserialize(file_get_contents($savePath));

		return $result;
	}

	public static function saveCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/coupon/';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where status='1'"
			));


		$total=count($loadData);

		for ($i=0; $i < $total; $i++) { 

			$fileName=String::makeFriendlyUrl(strip_tags($loadData[$i]['code']));

			$filePath=$savePath.$fileName.'.cache';

			File::create($filePath,serialize($loadData[$i]));	
		}

			
	}
	
	public static function insert($inputData=array())
	{
		Table::setTable('vouchers');

		$result=Table::insert($inputData,function($inputData){
		

			if(!isset($inputData['date_added']))
			{
				$inputData['date_added']=date('Y-m-d H:i:s');
			}


			return $inputData;

		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('vouchers');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('vouchers');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}