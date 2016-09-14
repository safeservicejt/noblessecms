<?php

class Customers
{
	public static function get($inputData=array())
	{
		Table::setTable('customers');

		Table::setFields('userid,points,commission,orders,reviews,balance,withdraw_summary,affiliaterankid,affiliate_orders');

		$inputData['orderby']=!isset($inputData['orderby'])?'order by userid desc':$inputData['orderby'];

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('customers');

		$result=Table::insert($inputData,function($inputData){

			if(!isset($inputData['affiliaterankid']))
			{
				$inputData['affiliaterankid']=FastEcommerce::$setting['affiliate_rankid'];
				$inputData['commission']=FastEcommerce::$setting['affiliate_percent'];
			}

			return $inputData;

		});

		CustomPlugins::load('after_customer_insert',$inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('customers');

		$result=Table::update($listID,$updateData,function($inputData){

			if(isset($inputData['withdraw_summary']))
			{
				$inputData['withdraw_summary']=addslashes($inputData['withdraw_summary']);
			}		

			return $inputData;
		});

		Customers::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('customers');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($userid)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$userid.'.cache';

		if(!file_exists($savePath))
		{
			return false;
		}

		return true;		
	}

	public static function removeCache($listID=array())
	{
		$listID=!is_array($listID)?array($listID):$listID;

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$id.'.cache';

			if(file_exists($savePath))
			{
				unlink($savePath);
			}

		}
	}

	public static function loadCache($userid)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$userid.'.cache';

		$loadData=false;

		if(!file_exists($savePath))
		{
			self::saveCache($userid);

			if(!file_exists($savePath))
			{
				return false;
			}

		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function saveCache($userid)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$userid.'.cache';

		$loadData=Users::loadCache($userid);

		if(!$loadData)
		{
			Users::saveCache($userid);

			$loadData=Users::loadCache($userid);
		}

		$result=$loadData;

		$loadCustomerData=self::get(array(
			'cache'=>'no',
			'where'=>"where userid='$userid'"
			));		
		
		if(!isset($loadCustomerData[0]['userid']))
		{
			self::insert(array(
				'userid'=>$userid,
				'commission'=>FastEcommerce::$setting['affiliate_percent'],
				'affiliaterankid'=>FastEcommerce::$setting['affiliate_rankid'],
				));

			$loadCustomerData=self::get(array(
				'cache'=>'no',
				'where'=>"where userid='$userid'"
				));				
		}	


		$saveData=array_merge($loadData,$loadCustomerData[0]);

		$result=$saveData;

		if(isset($result['userid']))
		{

			File::create($savePath,serialize($result));
		}
		
	}

	public static function up($field,$num=1,$addWhere='')
	{
		Table::setTable('customers');

		Table::up($field,$num,$addWhere);
	}

	public static function down($field,$num=1,$addWhere='')
	{
		Table::setTable('customers');

		Table::down($field,$num,$addWhere);
	}

}