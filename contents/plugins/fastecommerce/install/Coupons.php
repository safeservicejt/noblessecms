<?php

class Coupons
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

		$field="id,type,code,amount,date_start,date_end,date_added,status,freeshipping".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."coupons $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/coupons/'.$md5Query,$cacheTime);

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

				if(isset($row['date_start']))
				{
					$row['date_startFormat']=Render::dateFormat($row['date_start']);	
				}

				if(isset($row['date_end']))
				{
					$row['date_endFormat']=Render::dateFormat($row['date_end']);	
				}

				if(isset($row['date_added']))
				{
					$row['date_addedFormat']=Render::dateFormat($row['date_added']);	
				}
									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/coupons/'.$md5Query,serialize($result));

		// end save


		return $result;
		
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

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/coupons/';

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
		CustomPlugins::load('before_coupon_insert',$inputData);

		$addMultiAgrs='';

		$inputData['date_added']=date('Y-m-d H:i:s');

		
		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."coupons($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_coupon_insert',$inputData);

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

		CustomPlugins::load('before_coupon_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."coupons where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_coupon_remove',$post);

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

		CustomPlugins::load('before_coupon_update',$listID);
				
	
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

		Database::query("update ".Database::getPrefix()."coupons set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_coupon_update',$listID);

			return true;
		}

		return false;
	}


}