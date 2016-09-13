<?php

class AffiliatesRanks
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

		$field="id,title,date_added,status,commission,orders,image,parentid".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."affiliate_ranks $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/affiliate_ranks/'.$md5Query,$cacheTime);

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
		Cache::saveKey('dbcache/system/affiliate_ranks/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}

	public static function changeRank($userid,$rankid)
	{
		$userData=Customers::loadCache($userid);

		$rankData=self::loadCache($rankid);

		$orders=$rankData['orders'];

		if((int)$userData['affiliate_orders'] > (int)$orders)
		{
			$rankData['orders']=$userData['affiliate_orders'];
		}

		$valid=Customers::update($userid,array(
			'affiliaterankid'=>$rankData['id'],
			'commission'=>$rankData['commission'],
			'affiliate_orders'=>$rankData['orders'],
			));

		Customers::saveCache($userid);

	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/affiliate_ranks/';

		return $result;
	}	

	public static function loadCache($id='')
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/affiliateranks/'.$id.'.cache';

		$result=false;

		if(!file_exists($savePath))
		{
			
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				return false;
			}
		}

		$result=unserialize(file_get_contents($savePath));

		return $result;
	}

	public static function saveCache($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/affiliateranks/';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		$filePath=$savePath.$id.'.cache';

		File::create($filePath,serialize($loadData[0]));	
			
	}

	public static function saveCacheAll()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/affiliateranks/listRanks.cache';

		$loadData=self::get(array(
			'cache'=>'no',
			'orderby'=>'order by title asc',
			));

		File::create($savePath,serialize($loadData));	
			
	}

	public static function loadCacheAll()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/affiliateranks/listRanks.cache';

		$loadData=false;

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCacheAll();

			if(!file_exists($savePath))
			{
				return false;
			}

			$loadData=unserialize(file_get_contents($savePath));
		}

		return $loadData;	
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

		Database::query("insert into ".Database::getPrefix()."affiliate_ranks($insertKeys) values".$addMultiAgrs);

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

		$command="delete from ".Database::getPrefix()."affiliate_ranks where $whereQuery $addWhere";


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

		Database::query("update ".Database::getPrefix()."affiliate_ranks set $setUpdates where $whereQuery $addWhere");

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