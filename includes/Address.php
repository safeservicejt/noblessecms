<?php

class Address
{
	public static function get($inputData=array())
	{
		Table::setTable('address');

		Table::setFields('userid,firstname,lastname,phone,address_1,address_2,city,state,zipcode,countrycode,countryname');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('address');

		$result=Table::insert($inputData,'',function($inputData){
			if(isset($inputData['userid']))
			{
				Users::saveCache($inputData['userid']);
			}
		});

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('address');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('address');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}

	public static function up($keyName='',$total=1,$addWhere='')
	{
		Table::setTable('address');

		Table::up($keyName,$total,$addWhere);
	}


	public static function down($keyName='',$total=1,$addWhere='')
	{
		Table::setTable('address');

		Table::down($keyName,$total,$addWhere);
	}


}