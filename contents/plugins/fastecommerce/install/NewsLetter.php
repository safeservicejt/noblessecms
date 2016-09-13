<?php

class NewsLetter
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

		$field="id,email,date_added".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."newsletters $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/newsletters/'.$md5Query,$cacheTime);

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

									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/newsletters/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}



	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/newsletters/';

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

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		$addMultiAgrs='';

		$inputData['date_added']=date('Y-m-d H:i:s');

		
		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."newsletters($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;


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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."newsletters where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	


		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listID,'system/post');

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."newsletters set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();

			return true;
		}

		return false;
	}


}