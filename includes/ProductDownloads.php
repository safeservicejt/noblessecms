<?php

class ProductDownloads
{
	public static function get($inputData=array())
	{
		Table::setTable('product_downloads');

		Table::setFields('productid,downloadid');

		$result=Table::get($inputData);

		return $result;
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update product_downloads set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update product_downloads set $field=$field-$total $addWhere");
	}

	public static function insert($inputData=array())
	{
		Table::setTable('product_downloads');

		$result=Table::insert($inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('product_downloads');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('product_downloads');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}