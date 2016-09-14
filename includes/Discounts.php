<?php

class Discounts
{
	public static $data=array();

	public static function get($inputData=array())
	{
		Table::setTable('discounts');

		Table::setFields('id,date_added,date_discount,date_enddiscount,percent,status');

		$result=Table::get($inputData);

		return $result;
	}

	public static function before_frontend_start()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/discount.cache';
	
		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));

			$today=time();

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$time_start=(int)$loadData[$i]['time_start'];
				$time_end=(int)$loadData[$i]['time_end'];

				if($today >= $time_start && $today <= $time_end)
				{
					self::$data=$loadData[$i];

					break;
				}
			}

		}
		else
		{
			$today=date('Y-m-d 00:00:00');

			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where status='1' AND date_discount<='$today' AND date_enddiscount>='$today'"
				));

			if(isset($loadData[0]['id']))
			{
				self::$data=$loadData[0];

				File::create($savePath,serialize($loadData[0]));
			}			
		}

	}

	public static function saveCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/discount.cache';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where status='1'"
			));


		$total=count($loadData);

		for ($i=0; $i < $total; $i++) { 

			$loadData[$i]['time_start']=strtotime($loadData[$i]['date_discount']);

			$loadData[$i]['time_end']=strtotime($loadData[$i]['date_enddiscount']);

		}

		File::create($savePath,serialize($loadData));
	}

	public static function insert($inputData=array())
	{
		Table::setTable('discounts');

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
		Table::setTable('discounts');

		$result=Table::update($listID,$updateData);

		Discounts::saveCache();

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('discounts');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}