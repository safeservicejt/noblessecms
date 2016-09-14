<?php

class ProductReviews
{
	public static function get($inputData=array())
	{
		Table::setTable('product_reviews');

		Table::setFields('id,userid,rating,content,date_added,status,is_spam,productid');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['content']))
				{
					$rows[$i]['content']=stripslashes($rows[$i]['content']);
					
				}



			}

			return $rows;

		});

		return $result;
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update product_reviews set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update product_reviews set $field=$field-$total $addWhere");
	}

	public static function insert($inputData=array())
	{
		Table::setTable('product_reviews');

		$result=Table::insert($inputData,function($inputData){
		

			if(!isset($inputData['date_added']))
			{
				$inputData['date_added']=date('Y-m-d H:i:s');
			}


			if(isset($inputData['content']))
			{
				$inputData['content']=addslashes($inputData['content']);
			}
			

			return $inputData;

		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('product_reviews');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['content']))
			{
				$inputData['content']=addslashes($inputData['content']);
			}

			

			return $inputData;
		});

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('product_reviews');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}