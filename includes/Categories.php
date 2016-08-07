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

		$field="catid,descriptions,page_title,keywords,title,friendly_url,parentid,image,sort_order,date_added,status".$moreFields;

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
				if(isset($row['page_title']))
				{
					$row['page_title']=String::decode($row['page_title']);
				}
				if(isset($row['keywords']))
				{
					$row['keywords']=String::decode($row['keywords']);
				}
				if(isset($row['descriptions']))
				{
					$row['descriptions']=String::decode($row['descriptions']);
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

	public static function getRecursiveFromInput($inputData=array())
	{
		$loadAll=self::getRecursive($inputData);

		$catData=array();

		$loadMain=array();

		if(isset($loadAll[0]['catid']))
		{
			$total=count($loadAll);

			$totalInput=count($inputData);

			for ($i=0; $i < $totalInput; $i++) { 
				
				for ($j=0; $j < $total; $j++) { 
					
					if((int)$inputData[$i]['catid']==(int)$loadAll[$j]['catid'])
					{
						$inputData[$i]['title']=$loadAll[$j]['title'];
					}
				}
			}
		}

		return $inputData;
	}

	public static function getRecursive($inputData=array())
	{
		$inputData['cache']=isset($inputData['cache'])?$inputData['cache']:'no';

		$inputData['orderby']=isset($inputData['orderby'])?$inputData['orderby']:'order by title asc';

		$loadAll=self::get($inputData);

		$catData=array();

		$loadMain=array();

		if(isset($loadAll[0]['catid']))
		{
			$total=count($loadAll);

			for ($i=0; $i < $total; $i++) { 
				
				for ($j=1; $j < $total; $j++) { 
					
					if((int)$loadAll[$i]['catid']==(int)$loadAll[$j]['parentid'])
					{
						$loadAll[$j]['title']=$loadAll[$i]['title'].' -> '.$loadAll[$j]['title'];
					}
				}
			}
		}

		return $loadAll;
	}


	
	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/category/';

		return $result;
	}

	public static function saveCache($id)
	{
		$loadData=self::get(array(
			'where'=>"where catid='$id'"
			));

		if(isset($loadData[0]['catid']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/category/'.$loadData[0]['friendly_url'].'.cache';

			File::create($savePath,serialize($loadData[0]));			
		}

	}

	public static function loadCache($friendly_url='')
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/category/'.$friendly_url.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}
		else
		{
			$loadData=self::get(array(
				'where'=>"where friendly_url='$friendly_url'"
				));

			self::saveCache($loadData[0]['catid']);

			$result=$loadData[0];
		}

		return $result;

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

				if(!isset($theRow['friendly_url']))
				{
					$theRow['friendly_url']=String::makeFriendlyUrl(strip_tags($theRow['title']));
				}

				if(isset($theRow['title']))
				$theRow['title']=String::encode(strip_tags($theRow['title']));

				if(isset($theRow['page_title']))
				{
					$theRow['page_title']=String::encode(strip_tags($theRow['page_title']));
				}
				else
				{
					$theRow['page_title']=$theRow['title'];
				}
				

				if(isset($theRow['keywords']))
				$theRow['keywords']=String::encode(strip_tags($theRow['keywords']));

				if(isset($theRow['descriptions']))
				$theRow['descriptions']=String::encode(strip_tags($theRow['descriptions']));

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

			if(!isset($inputData['friendly_url']))
			{
				$inputData['friendly_url']=String::makeFriendlyUrl(strip_tags($inputData['title']));
			}

			if(isset($inputData['title']))
			$inputData['title']=String::encode(strip_tags($inputData['title']));

			if(isset($inputData['page_title']))
			{
				$inputData['page_title']=String::encode(strip_tags($inputData['page_title']));
			}
			else
			{
				$inputData['page_title']=$inputData['title'];
			}

			if(isset($inputData['keywords']))
			$inputData['keywords']=String::encode(strip_tags($inputData['keywords']));

			if(isset($inputData['descriptions']))
			$inputData['descriptions']=String::encode(strip_tags($inputData['descriptions']));

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

			$inputData['id']=$id;

			// self::update($id,array(
			// 	'friendly_url'=>$inputData['friendly_url'].'-'.$id
			// 	));

			CustomPlugins::load('after_category_insert',$inputData);


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

		if(isset($post['friendly_url']))
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where friendly_url='".$post['friendly_url']."' AND catid<>'".$listID[0]."'"
				));

			if(isset($loadData[0]['catid']))
			{
				return false;
			}

		}

		if(isset($post['descriptions']))
		{
			$post['descriptions']=String::encode($post['descriptions']);
		}
	
		if(isset($post['keywords']))
		{
			$post['keywords']=String::encode($post['keywords']);
		}
	
		if(isset($post['page_title']))
		{
			$post['page_title']=String::encode($post['page_title']);
		}
		
		Plugins::load('before_category_update',$listID);

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
			
			CustomPlugins::load('after_category_update',$listID);

			return true;
		}

		return false;
	}


}
?>