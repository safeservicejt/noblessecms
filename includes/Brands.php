<?php

class Brands
{
	public static function get($inputData=array())
	{
		Table::setTable('brands');

		Table::setFields('id,title,friendly_url,views,date_added,status');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['friendly_url']))
				{
					$rows[$i]['url']=System::getUrl().'post/'.$rows[$i]['friendly_url'].'.html';
				}


				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}

			}

			return $rows;

		});

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('brands');

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
		Table::setTable('brands');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			return $inputData;
		});

		Brands::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('brands');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		Table::setTable('brands');

		$result=Table::exists($id);

		return $result;
	}

	public static function loadCache($id)
	{
		Table::setTable('brands');

		$result=Table::loadCache($id,function($id){
			Brands::saveCache($id);
		});

		return $result;
	}

	public static function removeCache($id)
	{
		Table::setTable('brands');

		Table::removeCache($id);

	}

	public static function saveCache($listID)
	{
		Table::setTable('brands');


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
		Table::setTable('brands');

		Table::up($field,$num,$addWhere);
	}

	public static function down($field,$num=1,$addWhere='')
	{
		Table::setTable('brands');

		Table::down($field,$num,$addWhere);
	}

}