<?php

class ShippingRates
{
	public static $data=array();

	public static function get($inputData=array())
	{
		Table::setTable('shippingrates');

		Table::setFields('id,title,amount,status');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['amount']))
				{
					$rows[$i]['amountFormat']=FastEcommerce::money_format($rows[$i]['amount']);
				}


			}

			return $rows;

		});

		return $result;
	}

	public static function saveAllToCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/listAll.cache';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where status='1'"
			));

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData));
		}		
	}

	public static function loadAllFromCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/listAll.cache';

		$loadData=false;

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));
		}

		return $loadData;
	}

	public static function loadCache($id=0)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/'.$id.'.cache';

		$loadData=false;

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


	public static function saveCache($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(isset($loadData[0]['id']))
		{
			$savePath.=$id.'.cache';

			File::create($savePath,serialize($loadData[0]));
		}
	}

	public static function insert($inputData=array())
	{
		Table::setTable('shippingrates');

		$result=Table::insert($inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('shippingrates');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('shippingrates');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}