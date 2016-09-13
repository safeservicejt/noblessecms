<?php

class customers
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

		$field="userid,points,commission,orders,reviews,balance,withdraw_summary,affiliaterankid,affiliate_orders".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by userid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."customers $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/customers/'.$md5Query,$cacheTime);

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
				if(isset($row['points']))
				{
					$row['pointsFormat']=number_format($row['points']);
				}
				
				if(isset($row['commission']))
				{
					$row['commissionFormat']=number_format($row['commission']);
				}

				if(isset($row['orders']))
				{
					$row['ordersFormat']=number_format($row['orders']);
				}

				if(isset($row['reviews']))
				{
					$row['reviewsFormat']=number_format($row['reviews']);
				}

				if(isset($row['balance']))
				{
					$row['balanceFormat']=number_format($row['balance']);
				}

				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/customers/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}


	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."customers set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."customers set $field=$field-$total $addWhere");
	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/customers/';

		return $result;
	}	


	public static function exists($userid)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$userid.'.cache';

		if(!file_exists($savePath))
		{
			return false;
		}

		return true;		
	}

	public static function removeCache($listID=array())
	{
		$listID=!is_array($listID)?array($listID):$listID;

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$id.'.cache';

			if(file_exists($savePath))
			{
				unlink($savePath);
			}

		}
	}

	public static function loadCache($userid)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$userid.'.cache';

		$loadData=false;

		if(!file_exists($savePath))
		{
			self::saveCache($userid);

			if(!file_exists($savePath))
			{
				return false;
			}

		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function saveCache($userid)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/customer/'.$userid.'.cache';

		$loadData=Users::loadCache($userid);

		if(!$loadData)
		{
			Users::saveCache($userid);

			$loadData=Users::loadCache($userid);
		}

		$result=$loadData;

		$loadCustomerData=self::get(array(
			'cache'=>'no',
			'where'=>"where userid='$userid'"
			));		
		
		if(!isset($loadCustomerData[0]['userid']))
		{
			self::insert(array(
				'userid'=>$userid,
				'commission'=>FastEcommerce::$setting['affiliate_percent'],
				'affiliaterankid'=>FastEcommerce::$setting['affiliate_rankid'],
				));

			$loadCustomerData=self::get(array(
				'cache'=>'no',
				'where'=>"where userid='$userid'"
				));				
		}	


		$saveData=array_merge($loadData,$loadCustomerData[0]);

		$result=$saveData;

		if(isset($result['userid']))
		{

			File::create($savePath,serialize($result));
		}
		
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_customer_insert',$inputData);

		$addMultiAgrs='';

		if(!isset($inputData['affiliaterankid']))
		{
			$inputData['affiliaterankid']=FastEcommerce::$setting['affiliate_rankid'];
			$inputData['commission']=FastEcommerce::$setting['affiliate_percent'];
		}
		
		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."customers($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_customer_insert',$inputData);

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

		CustomPlugins::load('before_customer_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"userid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."customers where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_customer_remove',$post);

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

		CustomPlugins::load('before_customer_update',$listID);
		
		if(isset($post['withdraw_summary']))
		{
			$post['withdraw_summary']=String::encode($post['withdraw_summary']);
		}			
	
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"userid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."customers set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_customer_update',$listID);

			return true;
		}

		return false;
	}


}