<?php

class Reviews
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

		$field="id,productid,fullname,url,email,date_added,status,content,userid,report,rating".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."reviews $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/reviews/'.$md5Query,$cacheTime);

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

				if(isset($row['fullname']))
				{
					$row['fullname']=String::decode($row['fullname']);
				}

				if(isset($row['url']))
				{
					$row['url']=String::decode($row['url']);
				}

				if(isset($row['email']))
				{
					$row['email']=String::decode($row['email']);
				}

				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);

					// die($row['content']);
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
		Cache::saveKey('dbcache/system/reviews/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}



	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/reviews/';

		return $result;
	}	


	public static function saveCache($productid)
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where productid='$productid'"
			));

		if(isset($loadData[0]['productid']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/review/'.$productid.'.cache';

			File::create($savePath,serialize($loadData));			
		}

	}

	public static function loadCache($productid='')
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/review/'.$productid.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCache($productid);

			if(!file_exists($savePath))
			{
				$result=false;
			}
			else
			{
				$result=unserialize(file_get_contents($savePath));
			}
		}

		return $result;

	}

	public static function removeCache($listID=array())
	{
		$listID=!is_array($listID)?array($listID):$listID;

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			$savePath=ROOT_PATH.'application/caches/fastcache/review/'.$id.'.cache';

			if(file_exists($savePath))
			{
				unlink($savePath);
			}

		}
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_review_insert',$inputData);

		$addMultiAgrs='';

		$inputData['date_added']=date('Y-m-d H:i:s');

		if(isset($inputData['fullname']))
		{
			$inputData['fullname']=String::encode($inputData['fullname']);
		}

		if(isset($inputData['url']))
		{
			$inputData['url']=String::encode($inputData['url']);
		}

		if(isset($inputData['email']))
		{
			$inputData['email']=String::encode($inputData['email']);
		}

		if(isset($inputData['content']))
		{
			$inputData['content']=String::encode($inputData['content']);
		}

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."reviews($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_review_insert',$inputData);

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

		CustomPlugins::load('before_review_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."reviews where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_review_remove',$post);

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

		CustomPlugins::load('before_review_update',$listID);
				
	
		if(isset($post['content']))
		{
			$post['content']=String::encode($post['content']);
		}
	
		if(isset($post['fullname']))
		{
			$post['fullname']=String::encode($post['fullname']);
		}
	
		if(isset($post['url']))
		{
			$post['url']=String::encode($post['url']);
		}
	
		if(isset($post['email']))
		{
			$post['email']=String::encode($post['email']);
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."reviews set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_review_update',$listID);

			return true;
		}

		return false;
	}


}