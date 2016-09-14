<?php

class Reviews
{
	public static function get($inputData=array())
	{
		Table::setTable('reviews');

		Table::setFields('id,productid,fullname,url,email,date_added,status,content,userid,report,rating');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=String::decode($rows[$i]['title']);
				}

				if(isset($rows[$i]['fullname']))
				{
					$rows[$i]['fullname']=String::decode($rows[$i]['fullname']);
				}

				if(isset($rows[$i]['url']))
				{
					$rows[$i]['url']=String::decode($rows[$i]['url']);
				}

				if(isset($rows[$i]['email']))
				{
					$rows[$i]['email']=String::decode($rows[$i]['email']);
				}

				if(isset($rows[$i]['content']))
				{
					$rows[$i]['content']=String::decode($rows[$i]['content']);

					// die($rows[$i]['content']);
				}

				if(isset($rows[$i]['date_added']))
				{
					$rows[$i]['date_addedFormat']=Render::dateFormat($rows[$i]['date_added']);	
				}

			}

			return $rows;

		});

		return $result;
	}


	public static function saveCache($productid)
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where productid='$productid'"
			));

		if(isset($loadData[0]['productid']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/review/'.$productid.'.cache';

			File::create($savePath,serialize($loadData));			
		}

	}

	public static function loadCache($productid='')
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/review/'.$productid.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCache($productid);

			if(!file_exists($savePath))
			{
				$result=false;
			}
			else
			{
				$result=unserialize(file_get_contents($savePath));
			}
		}

		return $result;

	}

	public static function removeCache($listID=array())
	{
		$listID=!is_array($listID)?array($listID):$listID;

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			$savePath=ROOT_PATH.'application/caches/fastcache/review/'.$id.'.cache';

			if(file_exists($savePath))
			{
				unlink($savePath);
			}

		}
	}


	public static function insert($inputData=array())
	{
		Table::setTable('reviews');

		$result=Table::insert($inputData,function($inputData){

			$inputData['date_added']=date('Y-m-d H:i:s');

			if(isset($inputData['fullname']))
			{
				$inputData['fullname']=String::encode($inputData['fullname']);
			}

			if(isset($inputData['url']))
			{
				$inputData['url']=String::encode($inputData['url']);
			}

			if(isset($inputData['email']))
			{
				$inputData['email']=String::encode($inputData['email']);
			}

			if(isset($inputData['content']))
			{
				$inputData['content']=String::encode($inputData['content']);
			}

			return $inputData;

		},function($inputData){
			if(isset($inputData['id']))
			{
				self::update($inputData['id'],array(
					'friendly_url'=>String::makeFriendlyUrl(strip_tags($inputData['title'])).'-'.$inputData['id']
					));
			}
		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('reviews');

		$result=Table::update($listID,$updateData,function($inputData){
	
		
			if(isset($inputData['content']))
			{
				$inputData['content']=String::encode($inputData['content']);
			}
		
			if(isset($inputData['fullname']))
			{
				$inputData['fullname']=String::encode($inputData['fullname']);
			}
		
			if(isset($inputData['url']))
			{
				$inputData['url']=String::encode($inputData['url']);
			}
		
			if(isset($inputData['email']))
			{
				$inputData['email']=String::encode($inputData['email']);
			}

			return $inputData;
		});

		Post::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('reviews');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}