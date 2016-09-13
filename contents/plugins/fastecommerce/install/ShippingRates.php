<?php

class ShippingRates
{
	public static $data=array();

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

		$field="id,title,amount,status".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."shippingrates $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/shippingrates/'.$md5Query,$cacheTime);

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

				if(isset($row['amount']))
				{
					$row['amountFormat']=FastEcommerce::money_format($row['amount']);
				}
									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/shippingrates/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}


	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/shippingrates/';

		return $result;
	}	

	public static function saveAllToCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/listAll.cache';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where status='1'"
			));

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData));
		}		
	}

	public static function loadAllFromCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/listAll.cache';

		$loadData=false;

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));
		}

		return $loadData;
	}

	public static function loadCache($id=0)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/'.$id.'.cache';

		$loadData=false;

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


	public static function saveCache($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/shippingrates/';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(isset($loadData[0]['id']))
		{
			$savePath.=$id.'.cache';

			File::create($savePath,serialize($loadData[0]));
		}
	}



	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."shippingrates($insertKeys) values".$addMultiAgrs);

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

		$command="delete from ".Database::getPrefix()."shippingrates where $whereQuery $addWhere";


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

		Database::query("update ".Database::getPrefix()."shippingrates set $setUpdates where $whereQuery $addWhere");

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