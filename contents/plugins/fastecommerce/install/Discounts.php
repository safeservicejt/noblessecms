<?php

class Discounts
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

		$field="id,date_added,date_discount,date_enddiscount,percent,status".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."discounts $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/discounts/'.$md5Query,$cacheTime);

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
				if(isset($row['date_added']))
				{
					$row['date_addedFormat']=Render::dateFormat($row['date_added']);	
				}
				if(isset($row['date_discount']))
				{
					$row['date_discountFormat']=Render::dateFormat($row['date_discount']);	
				}
				if(isset($row['date_enddiscount']))
				{
					$row['date_enddiscountFormat']=Render::dateFormat($row['date_enddiscount']);	
				}
								
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/discounts/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}

	public static function before_frontend_start()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/discount.cache';
	
		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));

			$today=time();

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$time_start=(int)$loadData[$i]['time_start'];
				$time_end=(int)$loadData[$i]['time_end'];

				if($today >= $time_start && $today <= $time_end)
				{
					self::$data=$loadData[$i];

					break;
				}
			}

		}
		else
		{
			$today=date('Y-m-d 00:00:00');

			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where status='1' AND date_discount<='$today' AND date_enddiscount>='$today'"
				));

			if(isset($loadData[0]['id']))
			{
				self::$data=$loadData[0];

				File::create($savePath,serialize($loadData[0]));
			}			
		}

	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/discounts/';

		return $result;
	}	

	public static function saveCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/discount.cache';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where status='1'"
			));


		$total=count($loadData);

		for ($i=0; $i < $total; $i++) { 

			$loadData[$i]['time_start']=strtotime($loadData[$i]['date_discount']);

			$loadData[$i]['time_end']=strtotime($loadData[$i]['date_enddiscount']);

		}

		File::create($savePath,serialize($loadData));
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_discount_insert',$inputData);


		$addMultiAgrs='';

		$inputData['date_added']=date('Y-m-d H:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."discounts($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_discount_insert',$inputData);

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

		CustomPlugins::load('before_discount_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."discounts where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_discount_remove',$post);

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

		CustomPlugins::load('before_discount_update',$listID);
				
				
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

		Database::query("update ".Database::getPrefix()."discounts set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_discount_update',$listID);

			return true;
		}

		return false;
	}


}