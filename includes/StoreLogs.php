<?php

class StoreLogs
{
	public static function get($inputData=array())
	{
		Table::setTable('store_log');

		Table::setFields('id,content,date_added');

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

	public static function insert($inputData=array())
	{
		Table::setTable('store_log');

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
		Table::setTable('store_log');

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
		Table::setTable('store_log');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}