<?php

class AffiliatesWithdraws
{
	public static function get($inputData=array())
	{
		Table::setTable('affiliate_withdraws');

		Table::setFields('id,userid,date_added,money,status');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('affiliate_withdraws');

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
		Table::setTable('affiliate_withdraws');

		$result=Table::update($listID,$updateData);

		// AffiliatesWithdraws::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('affiliate_withdraws');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		Table::setTable('affiliate_withdraws');

		$result=Table::exists($id);

		return $result;
	}

	public static function loadCache($id)
	{
		Table::setTable('affiliate_withdraws');

		$result=Table::loadCache($id,function($id){
			AffiliatesWithdraws::saveCache($id);
		});

		return $result;
	}

	public static function removeCache($id)
	{
		Table::setTable('affiliate_withdraws');

		Table::removeCache($id);

	}

	public static function saveCache($listID)
	{
		Table::setTable('affiliate_withdraws');


		if(!is_array($listID))
		{
			$tmp=$listID;

			$listID=array($tmp);
		}

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			Table::saveCache($id);			
		}

	}

	public static function up($field,$num=1,$addWhere='')
	{
		Table::setTable('affiliate_withdraws');

		Table::up($field,$num,$addWhere);
	}

	public static function down($field,$num=1,$addWhere='')
	{
		Table::setTable('affiliate_withdraws');

		Table::down($field,$num,$addWhere);
	}

}