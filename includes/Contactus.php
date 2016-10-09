<?php

class Contactus
{
	public static function get($inputData=array())
	{
		Table::setTable('contactus');

		Table::setFields('id,fullname,email,content,date_added');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array(),$beforeInsert='',$afterInsert='')
	{
		Table::setTable('contactus');

		$result=Table::insert($inputData,$beforeInsert,$afterInsert);

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('contactus');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('contactus');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}