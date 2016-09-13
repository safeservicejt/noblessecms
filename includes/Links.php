<?php

class Links
{
	public static function get($inputData=array())
	{
		Table::setTable('links');

		Table::setFields('id,parentid,title,image,url,sort_order,date_added,status');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['image']))
				{
					$rows[$i]['imageUrl']=System::getUrl().$rows[$i]['image'];
				}

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}
				
				if(isset($rows[$i]['url']))
				{
					if(!preg_match('/^http/i', $rows[$i]['url']))
					{
						$rows[$i]['urlFormat']=System::getUrl().$rows[$i]['url'];
					}
				}
			}

			return $rows;

		});

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('links');

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

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('links');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('links');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		$savePath=ROOT_PATH.'caches/system/listLinks.cache';

		if(!file_exists($savePath))
		{
			return false;			
		}

		return true;
	}

	public static function loadCache($id)
	{
		$savePath=ROOT_PATH.'caches/system/listLinks.cache';

		if(!file_exists($savePath))
		{
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function saveCache()
	{
		$savePath=ROOT_PATH.'caches/system/listLinks.cache';

		$loadData=array();

		$loadData=self::getRecursive();

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData));
		}
		
	}


	public static function getRecursive()
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'cacheTime'=>230,
			'selectFields'=>'*',
			'orderby'=>'order by sort_order desc'
			));

		$result=array();


		if(isset($loadData[0]['id']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 

				if(!isset($loadData[$i]))
				{
					continue;
				}

				$parentid=$loadData[$i]['parentid'];

				$id=$loadData[$i]['id'];

				if((int)$parentid==0)
				for ($j=0; $j < $total; $j++) { 

					if(!isset($loadData[$j]))
					{
						continue;
					}					

					$child_parentid=$loadData[$j]['parentid'];

					$child_id=$loadData[$j]['id'];

					if((int)$id==(int)$child_parentid)
					{
						$loadData[$i]['child'][]=$loadData[$j];

						unset($loadData[$j]);
					}
				}
			}
		}
		else
		{
			return $loadData;
		}

		return $loadData;
	}	
}