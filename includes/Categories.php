<?php

class Categories
{
	public static $listCategories=array();

	public static $totalSub=0;

	public static $subPosition=0;

	public static $thisCatid=0;

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="catid,cattitle,friendly_url,parentid,sort_order,image,date_added,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from categories $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		// Load dbcache

		$loadCache=DBCache::get($queryCMD);

		if($loadCache!=false)
		{
			return $loadCache;
		}

		// end load

		$query=Database::query($queryCMD);

		if(isset(Database::$error[5]))
		{
			return false;
		}

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['cattitle']))
				{
					$row['cattitle']=String::decode($row['cattitle']);
				}

				if(isset($row['image']))
				{
					$row['imageUrl']=Render::thumbnail($row['image']);
				}

				$row['date_added']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';

				if(isset($row['friendly_url']))
				{
					$row['url']=Url::category($row);
				}		

				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save

		// $result=self::plugin_hook_comment($result);

		return $result;
		
	}	

	public function sortList($loadData=array())
	{
		if(!isset($loadData[0]['catid']))
		{
			$loadData=self::get();
		}

		$newcats = Array();
		foreach ($loadData as $key => $cat){
		    if ($cat['parentid'] == 0){
		        $cat['sub'] = Array();
		        foreach ($loadData as $keysub => $subcat){
		            if ($subcat['parentid'] == $cat['catid']){
		                $cat['sub'][] = $subcat;
		                unset($loadData[$keysub]);
		            }
		        }
		        $newcats[] = $cat;
		        unset($loadData[$key]);
		    }
		}	

		return $newcats;	
	}
	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['cattitle']))
		{
			$post['cattitle']=String::encode($post['cattitle']);
		}

		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";		

		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{

			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"catid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update categories set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			self::saveCache();

			return true;
		}

		return false;
	}

	public function saveCache()
	{
		$loadData=self::get(array(
			'orderby'=>'order by cattitle asc'
			));

		$total=count($loadData);

		$resultData=array();

		for($i=0;$i<$total;$i++)
		{
			$theID=$loadData[$i]['catid'];

			$resultData[$theID]=$loadData[$i];
		}

		Cache::saveKey('listCategories',json_encode($resultData));
	}

	public function getCache()
	{
		if(!$loadData=Cache::loadKey('listCategories',-1))
		{
			return false;
		}

		$loadData=json_decode($loadData,true);

		self::$listCategories=$loadData;

		return $loadData;
	}

	public function insert($inputData=array())
	{
		$inputData['parentid']=isset($inputData['parentid'])?$inputData['parentid']:'0';

		$inputData['friendly_url']=Url::makeFriendly($inputData['cattitle']);

		$inputData['date_added']=date('Y-m-d h:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Plugins::load('before_insert_category',$inputData);

		Database::query("insert into categories($insertKeys) values($insertValues)");


		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			// Multidb::increasePost();

			Plugins::load('after_insert_category',$inputData);

			return $id;		
		}

		return false;

	} 


	public function remove($post=array())
	{


		if(is_numeric($post))
		{
			$catid=$post;

			unset($post);

			$post=array($catid);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"catid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="select image from categories where catid in ($listID)";

		$query=Database::query($command);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		while($row=Database::fetch_assoc($query))
		{
			$thumbnail=$row['image'];

			if(!is_dir(ROOT_PATH.$thumbnail) && file_exists(ROOT_PATH.$thumbnail))
			{
				unlink(ROOT_PATH.$thumbnail);
			}
		}
	
		$command="delete from categories where $whereQuery $addWhere";

		Database::query($command);	

		self::saveCache();

		return true;
	}





}
?>