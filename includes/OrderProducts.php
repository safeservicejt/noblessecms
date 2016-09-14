<?php

class OrderProducts
{
	public static function get($inputData=array())
	{
		Table::setTable('order_products');

		Table::setFields('orderid,productid,quantity,price,total,log');

		$inputData['orderby']=!isset($inputData['orderby'])?'order by orderid desc':$inputData['orderby'];

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('order_products');

		$result=Table::insert($inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('order_products');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('order_products');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}

}