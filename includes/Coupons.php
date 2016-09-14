<?php

class Coupons
{
	public static function get($inputData=array())
	{
		Table::setTable('coupons');

		Table::setFields('id,type,code,amount,date_start,date_end,date_added,status,freeshipping');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['friendly_url']))
				{
					$rows[$i]['url']=System::getUrl().'post/'.$rows[$i]['friendly_url'].'.html';
				}

				if(isset($rows[$i]['image']))
				{
					$rows[$i]['imageUrl']=System::getUrl().$rows[$i]['image'];
				}

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}

				if(isset($rows[$i]['page_title']))
				{
					$rows[$i]['page_title']=stripslashes($rows[$i]['page_title']);
				}

				if(isset($rows[$i]['descriptions']))
				{
					$rows[$i]['descriptions']=stripslashes($rows[$i]['descriptions']);
				}

				if(isset($rows[$i]['keywords']))
				{
					$rows[$i]['keywords']=stripslashes($rows[$i]['keywords']);
				}

				if(isset($rows[$i]['images_data']) && isset($rows[$i]['images_data'][5]))
				{
					$rows[$i]['images_data']=unserialize($rows[$i]['images_data']);
				}

				if(isset($rows[$i]['category_data']) && isset($rows[$i]['category_data'][5]))
				{
					$rows[$i]['category_data']=unserialize($rows[$i]['category_data']);
				}

				if(isset($rows[$i]['tag_data']) && isset($rows[$i]['tag_data'][5]))
				{
					$rows[$i]['tag_data']=unserialize($rows[$i]['tag_data']);
				}

				if(isset($rows[$i]['content']))
				{
					$rows[$i]['content']=stripslashes($rows[$i]['content']);
					
					if($inputData['isHook']=='yes')
					{

					}
				}



			}

			return $rows;

		});

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('coupons');

		$result=Table::insert($inputData,function($inputData){
			if(!isset($inputData['userid']))
			{
				$inputData['userid']=Users::$id;
			}

			if(!isset($inputData['date_added']))
			{
				$inputData['date_added']=date('Y-m-d H:i:s');
			}


			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			if(!isset($inputData['page_title']) || !isset($inputData['page_title'][5]))
			{
				$inputData['page_title']=$inputData['title'];
			}

			if(isset($inputData['descriptions']))
			{
				$inputData['descriptions']=addslashes($inputData['descriptions']);
			}

			if(isset($inputData['page_title']))
			{
				$inputData['page_title']=addslashes($inputData['page_title']);
			}

			if(isset($inputData['keywords']))
			{
				$inputData['keywords']=addslashes($inputData['keywords']);
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
		Table::setTable('coupons');

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
		Table::setTable('coupons');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($code='')
	{
		$fileName=String::makeFriendlyUrl(strip_tags($code));

		$savePath=ROOT_PATH.'contents/fastecommerce/coupon/'.$fileName.'.cache';

		$result=true;

		if(!file_exists($savePath))
		{
			$result=false;
		}

		return $result;
	}

	public static function loadCache($code='')
	{
		$fileName=String::makeFriendlyUrl(strip_tags($code));

		$savePath=ROOT_PATH.'contents/fastecommerce/coupon/'.$fileName.'.cache';

		$result=false;

		if(!file_exists($savePath))
		{
			
			self::saveCache();

			if(!file_exists($savePath))
			{
				return false;
			}
		}

		$result=unserialize(file_get_contents($savePath));

		return $result;
	}

	public static function saveCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/coupon/';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where status='1'"
			));


		$total=count($loadData);

		for ($i=0; $i < $total; $i++) { 

			$fileName=String::makeFriendlyUrl(strip_tags($loadData[$i]['code']));

			$filePath=$savePath.$fileName.'.cache';

			File::create($filePath,serialize($loadData[$i]));	
		}

			
	}

	public static function format($code)
	{
		$result='';

		$loadData=self::loadCache($code);

		if(!$loadData)
		{
			$result='';
		}
		else
		{
			switch ($loadData['type']) {
				case 'percent':
					$result=$loadData['amount'].'%';
					break;
				case 'percent':
					$result=FastEcommerce::money_format($loadData['amount']);
					break;
				
			}
		}

		return $result;
	}
	
	public static function up($field,$num=1,$addWhere='')
	{
		Table::setTable('coupons');

		Table::up($field,$num,$addWhere);
	}

	public static function down($field,$num=1,$addWhere='')
	{
		Table::setTable('coupons');

		Table::down($field,$num,$addWhere);
	}

}