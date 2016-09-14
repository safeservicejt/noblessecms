<?php

class Downloads
{
	public static function get($inputData=array())
	{
		Table::setTable('downloads');

		Table::setFields('id,path,title,status,date_added');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}

			}

			return $rows;

		});

		return $result;
	}

	public static function urlInOrder($userid,$orderid,$productid,$filePath)
	{
		$url=$userid.':'.$orderid.':'.$productid.':'.$filePath;

		$hash=base64_encode(String::encrypt($url));

		$url=System::getUrl().'api/plugin/fastecommerce/download_in_order/'.$hash;

		return $url;
	}
	
	public static function insert($inputData=array())
	{
		Table::setTable('downloads');

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

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('downloads');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			if(isset($inputData['page_title']))
			{
				$inputData['page_title']=addslashes($inputData['page_title']);
			}

			if(isset($inputData['descriptions']))
			{
				$inputData['descriptions']=addslashes($inputData['descriptions']);
			}

			if(isset($inputData['keywords']))
			{
				$inputData['keywords']=addslashes($inputData['keywords']);
			}

			if(isset($inputData['content']))
			{
				$inputData['content']=addslashes($inputData['content']);
			}

			

			return $inputData;
		});

		Post::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('downloads');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}