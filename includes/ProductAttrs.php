<?php

class ProductAttrs
{
	public static function get($inputData=array())
	{
		Table::setTable('product_attrs');

		Table::setFields('id,title,productid,price,value');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}


			}

			return $rows;

		});

		return $result;
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update product_attrs set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update product_attrs set $field=$field-$total $addWhere");
	}

	public static function insert($inputData=array())
	{
		Table::setTable('product_attrs');

		$result=Table::insert($inputData,function($inputData){
			

			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}


			return $inputData;

		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('product_attrs');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}


			return $inputData;
		});

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('product_attrs');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}