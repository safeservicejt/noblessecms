<?php

class ProductDiscounts
{
	public static function get($inputData=array())
	{
		Table::setTable('product_discounts');

		Table::setFields('productid,date_discount,date_enddiscount,percent,date_added,status,product_title,product_friendly_url');

		$result=Table::get($inputData);

		return $result;
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update product_discounts set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update product_discounts set $field=$field-$total $addWhere");
	}

	public static function insert($inputData=array())
	{
		Table::setTable('product_discounts');

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
		Table::setTable('product_discounts');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('product_discounts');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}