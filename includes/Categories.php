<?php

class Categories
{

	public static function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$moreFields=isset($inputData['moreFields'])?','.$inputData['moreFields']:'';

		$field="catid,title,friendly_url,parentid,image,sort_order,date_added,status".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by catid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;

		
		$command="select $selectFields from ".$prefix."categories $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=Cache::loadKey('dbcache/system/category/'.$md5Query,$cacheTime);

			if($loadCache!=false)
			{
				$loadCache=unserialize($loadCache);
				return $loadCache;
			}

			// end load			
		}

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
				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}
				
				if(isset($row['friendly_url']))
				{
					$row['url']=self::url($row);
				}

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);
											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		// Save dbcache
		Cache::saveKey('dbcache/system/category/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}
	public static function api($action)
	{
		Model::load('api/categories');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}

	public static function url($inputData)
	{
		$url=Url::category($inputData);

		return $url;
	}


	public static function loadCache($method='titleAsc',$limit=30)
	{
		// if((int)$limit > 30)
		// {
		// 	return false;
		// }
		
		// $savePath=self::cachePath();

		// $method=strtolower($method);

		// $loadData=array();

		// switch ($method) {
		// 	case 'titleasc':
		// 		if(file_exists($savePath.'titleAsc.cache'))
		// 		$loadData=unserialize(file_get_contents($savePath.'titleAsc.cache'));
		// 		break;

		// 	case 'titledesc':
		// 		if(file_exists($savePath.'titleDesc.cache'))
		// 		$loadData=unserialize(file_get_contents($savePath.'titleDesc.cache'));
		// 		break;

		// 	case 'orderasc':
		// 		if(file_exists($savePath.'OrderAsc.cache'))
		// 		$loadData=unserialize(file_get_contents($savePath.'OrderAsc.cache'));
		// 		break;

		// 	case 'orderdesc':
		// 		if(file_exists($savePath.'OrderDesc.cache'))
		// 		$loadData=unserialize(file_get_contents($savePath.'OrderDesc.cache'));
		// 		break;
		// }

		// return $loadData;
	}
	
	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/category/';

		return $result;
	}

	public static function saveCache()
	{
		// $savePath=self::cachePath();

		// $loadData=self::get(array(
		// 	'cache'=>'no',
		// 	'limitShow'=>30,
		// 	'orderby'=>'order by title asc'
		// 	));

		// File::create($savePath.'titleAsc.cache',serialize($loadData));

		// $loadData=self::get(array(
		// 	'cache'=>'no',
		// 	'limitShow'=>30,
		// 	'orderby'=>'order by desc asc'
		// 	));

		// File::create($savePath.'titleDesc.cache',serialize($loadData));

		// $loadData=self::get(array(
		// 	'cache'=>'no',
		// 	'limitShow'=>30,
		// 	'orderby'=>'order by sort_order asc'
		// 	));

		// File::create($savePath.'OrderAsc.cache',serialize($loadData));

		// $loadData=self::get(array(
		// 	'cache'=>'no',
		// 	'limitShow'=>30,
		// 	'orderby'=>'order by sort_order desc'
		// 	));

		// File::create($savePath.'OrderDesc.cache',serialize($loadData));


	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		Plugins::load('before_category_insert',$inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d H:i:s');

				$theRow['friendly_url']=String::makeFriendlyUrl(strip_tags($theRow['title']));

				if(isset($theRow['title']))
				$theRow['title']=String::encode(strip_tags($theRow['title']));

				$keyNames=array_keys($theRow);

				$insertKeys=implode(',', $keyNames);

				$keyValues=array_values($theRow);

				$insertValues="'".implode("','", $keyValues)."'";

				$addMultiAgrs.="($insertValues), ";

		    }

		    $addMultiAgrs=substr($addMultiAgrs, 0,strlen($addMultiAgrs)-2);
		}
		else
		{
			$inputData['date_added']=date('Y-m-d H:i:s');

			$inputData['friendly_url']=String::makeFriendlyUrl(strip_tags($inputData['title']));

			if(isset($inputData['title']))
			$inputData['title']=String::encode(strip_tags($inputData['title']));

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".Database::getPrefix()."categories($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/category');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			Plugins::load('after_category_insert',$inputData);

			self::saveCache();

			CustomPlugins::load('after_category_insert');


			return $id;	
		}

		return false;
	
	}

	public static function remove($post=array(),$whereQuery='',$addWhere='')
	{


		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		Plugins::load('before_category_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"catid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."categories where $whereQuery $addWhere";

		Database::query($command);

		Plugins::load('after_category_remove',$post);

		self::saveCache();

		CustomPlugins::load('after_category_remove',$post);

		// DBCache::removeDir('system/category');
		
		// DBCache::removeCache($listID,'system/category');

		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		Plugins::load('before_category_update',$listID);

		if(isset($post['title']))
		{
			$post['title']=String::encode(strip_tags($post['title']));

			$post['friendly_url']=String::makeFriendlyUrl(strip_tags($post['title']));

			$loadPost=self::get(array(
				'where'=>"where friendly_url='".$post['friendly_url']."'"
				));

			if(isset($loadPost[0]['catid']) && (int)$loadPost[0]['catid']<>(int)$listID[0])
			{
				return false;
			}			
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

		Database::query("update ".Database::getPrefix()."categories set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/category');

		// DBCache::removeCache($listIDs,'system/category');

		if(!$error=Database::hasError())
		{
			Plugins::load('after_category_update',$listID);

			self::saveCache();
			
			CustomPlugins::load('after_category_update',$listID);

			return true;
		}

		return false;
	}


}
?>