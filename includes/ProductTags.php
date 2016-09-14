<?php

class ProductTags
{
	public static function get($inputData=array())
	{
		Table::setTable('product_tags');

		Table::setFields('productid,title,friendly_url,views,product_title,product_friendly_url');

		$inputData['orderby']=!isset($inputData['orderby'])?'order by productid desc':$inputData['orderby'];

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['friendly_url']))
				{
					$rows[$i]['url']=System::getUrl().'tag/'.$rows[$i]['friendly_url'];
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

	public static function add($id,$tagList='')
	{
		if(!isset($tagList[1]))
		{
			return false;
		}

		$loadData=Products::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($loadData[0]['id']))
		{
			return false;
		}

		$split=explode(',', $tagList);

		$total=count($split);

		for ($i=0; $i < $total; $i++) { 

			$theTag=trim($split[$i]);

			self::insert(array(
				'productid'=>$id,
				'title'=>$theTag,
				'product_title'=>$loadData[0]['title'],
				'product_friendly_url'=>$loadData[0]['url']
				));
		}
	}


	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."products set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."products set $field=$field-$total $addWhere");
	}
	

	public static function saveCache($friendly_url)
	{
		$loadData=self::get(array(
			'selectFields'=>'*',
			'where'=>"where friendly_url='$friendly_url'"
			));

		if(isset($loadData[0]['friendly_url']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/page/'.$friendly_url.'.cache';

			File::create($savePath,serialize($loadData[0]));			
		}

	}

	public static function loadCache($friendly_url='')
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/page/'.$friendly_url.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCache($friendly_url);

			if(!file_exists($savePath))
			{
				$result=false;
			}
		}

		return $result;

	}

	
	public static function insert($inputData=array())
	{
		Table::setTable('product_tags');

		$result=Table::insert($inputData,function($inputData){

			if(!isset($inputData['friendly_url']))
			{
				$inputData['friendly_url']=String::makeFriendlyUrl(strip_tags($inputData['title']));
			}
			
			$inputData['title']=String::encode(strip_tags($inputData['title']));

			$inputData['product_title']=String::encode(strip_tags($inputData['product_title']));

			

			return $inputData;

		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('product_tags');

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
		Table::setTable('product_tags');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}