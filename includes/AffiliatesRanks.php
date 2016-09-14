<?php

class AffiliatesRanks
{
	public static function get($inputData=array())
	{
		Table::setTable('affiliate_ranks');

		Table::setFields('id,title,date_added,status,commission,orders,image,parentid');

		$result=Table::get($inputData);

		return $result;
	}

	public static function changeRank($userid,$rankid)
	{
		$userData=Customers::loadCache($userid);

		$rankData=self::loadCache($rankid);

		$orders=$rankData['orders'];

		if((int)$userData['affiliate_orders'] > (int)$orders)
		{
			$rankData['orders']=$userData['affiliate_orders'];
		}

		$valid=Customers::update($userid,array(
			'affiliaterankid'=>$rankData['id'],
			'commission'=>$rankData['commission'],
			'affiliate_orders'=>$rankData['orders'],
			));

		Customers::saveCache($userid);

	}

	public static function insert($inputData=array())
	{
		Table::setTable('affiliate_ranks');

		$result=Table::insert($inputData,function($inputData){
		
			if(!isset($inputData['date_added']))
			{
				$inputData['date_added']=date('Y-m-d H:i:s');
			}


			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}


			return $inputData;

		});

		AffiliatesRanks::saveCacheAll();

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('affiliate_ranks');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			

			return $inputData;
		});

		AffiliatesRanks::saveCache($listID);

		AffiliatesRanks::saveCacheAll();

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('affiliate_ranks');

		$result=Table::remove($inputIDs,$whereQuery);

		AffiliatesRanks::saveCacheAll();

		return $result;
	}


	public static function exists($id)
	{
		Table::setTable('affiliate_ranks');

		$result=Table::exists($id);

		return $result;
	}

	public static function loadCache($id)
	{
		Table::setTable('affiliate_ranks');

		$result=Table::loadCache($id,function($id){
			AffiliatesRanks::saveCache($id);
		});

		return $result;
	}

	public static function removeCache($id)
	{
		Table::setTable('affiliate_ranks');

		Table::removeCache($id);

	}

	public static function saveCache($listID)
	{
		Table::setTable('affiliate_ranks');


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

	public static function saveCacheAll()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/affiliateranks/listRanks.cache';

		$loadData=self::get(array(
			'cache'=>'no',
			'orderby'=>'order by title asc',
			));

		File::create($savePath,serialize($loadData));	
			
	}

	public static function loadCacheAll()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/affiliateranks/listRanks.cache';

		$loadData=false;

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCacheAll();

			if(!file_exists($savePath))
			{
				return false;
			}

			$loadData=unserialize(file_get_contents($savePath));
		}

		return $loadData;	
	}

	public static function up($field,$num=1,$addWhere='')
	{
		Table::setTable('affiliate_ranks');

		Table::up($field,$num,$addWhere);
	}

	public static function down($field,$num=1,$addWhere='')
	{
		Table::setTable('affiliate_ranks');

		Table::down($field,$num,$addWhere);
	}

}