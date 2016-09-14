<?php

class AffiliatesStats
{
	public static function get($inputData=array())
	{
		Table::setTable('affiliate_stats');

		Table::setFields('id,userid,money,date_added,status,orderid');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('affiliate_stats');

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
		Table::setTable('affiliate_stats');

		$result=Table::update($listID,$updateData);

		AffiliatesStats::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('affiliate_stats');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		Table::setTable('affiliate_stats');

		$result=Table::exists($id);

		return $result;
	}

	public static function loadCache($id)
	{
		Table::setTable('affiliate_stats');

		$result=Table::loadCache($id,function($id){
			AffiliatesStats::saveCache($id);
		});

		return $result;
	}

	public static function removeCache($id)
	{
		Table::setTable('affiliate_stats');

		Table::removeCache($id);

	}

	public static function saveCache($listID)
	{
		Table::setTable('affiliate_stats');


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
		Table::setTable('affiliate_stats');

		Table::up($field,$num,$addWhere);
	}

	public static function down($field,$num=1,$addWhere='')
	{
		Table::setTable('affiliate_stats');

		Table::down($field,$num,$addWhere);
	}

}