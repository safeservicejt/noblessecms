<?php

class ProductBrands
{
	public static function get($inputData=array())
	{
		Table::setTable('product_brands');

		Table::setFields('productid,brandid,product_title,product_friendly_url,brand_title,brand_friendly_url');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('product_brands');

		$result=Table::insert($inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('product_brands');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('product_brands');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}