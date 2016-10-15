<?php

class Categories
{
	public static function get($inputData=array())
	{
		Table::setTable('categories');

		Table::setFields('id,title,friendly_url,date_added,status,image,views,page_title,descriptions,keywords,sort_order,parentid');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 
				if(isset($rows[$i]['image']))
				{
					$rows[$i]['imageUrl']=System::getUrl().$rows[$i]['image'];
				}

				if(isset($rows[$i]['friendly_url']))
				{
					$rows[$i]['url']=System::getUrl().'category/'.$rows[$i]['friendly_url'];
				}

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);

					$rows[$i]['title']=Render::runTableContentProcess('pages','title',$rows[$i]['title']);
				}

				if(isset($rows[$i]['page_title']))
				{
					$rows[$i]['page_title']=stripslashes($rows[$i]['page_title']);

					$rows[$i]['page_title']=Render::runTableContentProcess('pages','page_title',$rows[$i]['page_title']);
				}

				if(isset($rows[$i]['descriptions']))
				{
					$rows[$i]['descriptions']=stripslashes($rows[$i]['descriptions']);

					$rows[$i]['descriptions']=Render::runTableContentProcess('pages','descriptions',$rows[$i]['descriptions']);
				}

				if(isset($rows[$i]['keywords']))
				{
					$rows[$i]['keywords']=stripslashes($rows[$i]['keywords']);

					$rows[$i]['keywords']=Render::runTableContentProcess('pages','keywords',$rows[$i]['keywords']);
				}

								
			}

			return $rows;

		});

		return $result;
	}

	public static function getRecursive($inputData=array(),$spaceChar='->')
	{
		$inputData['cache']=isset($inputData['cache'])?$inputData['cache']:'no';

		$inputData['orderby']=isset($inputData['orderby'])?$inputData['orderby']:'order by title asc';

		$inputData['selectFields']=!isset($inputData['selectFields'])?'*':$inputData['selectFields'];

		$loadAll=self::get($inputData);

		$catData=array();

		$loadMain=array();

		if(isset($loadAll[0]['id']))
		{
			$total=count($loadAll);

			for ($i=0; $i < $total; $i++) { 
				
				for ($j=1; $j < $total; $j++) { 
					
					if((int)$loadAll[$i]['id']==(int)$loadAll[$j]['parentid'])
					{
						$loadAll[$j]['title']=$loadAll[$i]['title'].' '.$spaceChar.' '.$loadAll[$j]['title'];
					}
				}
			}
		}

		return $loadAll;
	}

	public static function getRecursiveFromInput($inputData=array())
	{
		$loadAll=self::getRecursive($inputData);

		$catData=array();

		$loadMain=array();

		if(isset($loadAll[0]['id']))
		{
			$total=count($loadAll);

			$totalInput=count($inputData);

			for ($i=0; $i < $totalInput; $i++) { 
				
				for ($j=0; $j < $total; $j++) { 
					
					if((int)$inputData[$i]['id']==(int)$loadAll[$j]['id'])
					{
						$inputData[$i]['title']=$loadAll[$j]['title'];
					}
				}
			}
		}

		return $inputData;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('categories');

		$result=Table::insert($inputData,function($insertData){
			if(!isset($insertData['date_added']))
			{
				$insertData['date_added']=date('Y-m-d H:i:s');
			}

			if(isset($insertData['title']))
			{
				$insertData['title']=addslashes($insertData['title']);
			}

			if(!isset($insertData['page_title']) || !isset($insertData['page_title'][5]))
			{
				$insertData['page_title']=$insertData['title'];
			}

			if(isset($insertData['descriptions']))
			{
				$insertData['descriptions']=addslashes($insertData['descriptions']);
			}

			if(isset($insertData['page_title']))
			{
				$insertData['page_title']=addslashes($insertData['page_title']);
			}

			if(isset($insertData['keywords']))
			{
				$insertData['keywords']=addslashes($insertData['keywords']);
			}

			return $insertData;
		},function($inputData){
			if(isset($inputData['id']))
			{
				self::update($inputData['id'],array(
					'friendly_url'=>Strings::makeFriendlyUrl(strip_tags($inputData['title'])).'-'.$inputData['id']
					));

				Categories::saveCache($inputData['id']);
			}
		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('categories');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			if(isset($inputData['title']) && (!isset($inputData['page_title']) || !isset($inputData['page_title'][5])))
			{
				$inputData['page_title']=$inputData['title'];
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

			return $inputData;
		});

		Categories::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('categories');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		Table::setTable('categories');

		$result=Table::exists($id);

		return $result;
	}

	public static function loadCache($id)
	{
		Table::setTable('categories');

		$result=Table::loadCache($id,function($id){
			Categories::saveCache($id);
		});

		if(isset($result['image']))
		{
			$result['imageUrl']=System::getUrl().$result['image'];
		}

		if(isset($result['friendly_url']))
		{
			$result['url']=System::getUrl().'category/'.$result['friendly_url'];
		}		

		return $result;
	}

	public static function removeCache($id)
	{
		Table::setTable('categories');

		Table::removeCache($id);

	}

	public static function saveCache($id)
	{
		Table::setTable('categories');

		Table::saveCache($id);
	}
}