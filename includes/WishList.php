<?php

class WishList
{
	public static $data=array();

	public static function get($inputData=array())
	{
		Table::setTable('wishlist');

		Table::setFields('id,date_added,userid,productid');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('wishlist');

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
		Table::setTable('wishlist');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('wishlist');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}