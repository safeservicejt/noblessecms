<?php

class Logs
{
	public static function get($inputData=array())
	{
		Table::setTable('logs');

		Table::setFields('id,date_added,content');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array(),$beforeInsert='',$afterInsert='')
	{
		Table::setTable('logs');

		$result=Table::insert($inputData,$beforeInsert,$afterInsert);

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('logs');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('logs');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}