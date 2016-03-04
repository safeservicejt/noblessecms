<?php

class Widgets
{
	public static $listCaches=array('loaded'=>'no');

	public static $canInstall='no';

	public static $canUninstall='no';

	public static $canAddZone='no';

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

		$field="id,method_call,class,func,path,zonename,date_added,sort_order,status".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by sort_order desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;

		
		$command="select $selectFields from ".$prefix."widgets $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=Cache::loadKey('dbcache/system/widgets/'.$md5Query,$cacheTime);

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
		Cache::saveKey('dbcache/system/widgets/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}
	public static function api($action)
	{
		Model::load('api/widgets');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/widgets/'.Database::getPrefix().'widgets.cache';

		return $result;
	}

	public static function saveCache()
	{
		$savePath=self::cachePath();

		$loadData=self::get(array(
			'cache'=>'no'
			));

		$result=array();

		if(isset($loadData[0]['id']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$zonename=$loadData[$i]['zonename'];

				$result[$zonename][]=$loadData[$i];
			}
		}

		File::create($savePath,serialize($result));
	}

	public static function loadCache()
	{
		$savePath=self::cachePath();

		if(isset(self::$listCaches['loaded']))
		{
			if(file_exists($savePath))
			{
				$loadData=unserialize(file_get_contents($savePath));

				self::$listCaches=$loadData;
			}
		}
	}

	public static function zonePath()
	{
		$result=ROOT_PATH.'application/caches/widgets/'.Database::getPrefix().'widgets.cache';

		return $result;
	}

	public static function addZone($zonename='')
	{
		if(!isset($zonename[1]))
		{
			return false;
		}

		$zonePath=self::zonePath();

		$result=array();

		if(file_exists($zonePath))
		{
			$result=unserialize(file_get_contents($zonePath));
		}

		$result[]=$zonename;

		$result=array_unique($result);

		File::create($zonePath,serialize($result));
	}



	public static function getZoneList()
	{
		$listZone=array(
			'content_top','content_bottom','content_left','content_bottom'
			);

		$zonePath=self::zonePath();

		$result=array();

		if(file_exists($zonePath))
		{
			$result=unserialize(file_get_contents($zonePath));
		}

		$result=array_merge($listZone);

		$result=array_unique($result);		

		return $result;
	}

	public static function removeFromZone($inputData=array())
	{
		$method=isset($inputData['method'])?$inputData['method']:'path';

		$addWhere='';

		switch ($method) {
			case 'path':
				$addWhere="where path LIKE '%".$inputData['path']."%'";
				break;
			case 'func':
				$addWhere="where func='".$inputData['func']."'";
				break;
			case 'class':
				$addWhere="where class='".$inputData['class']."'";
				break;
			case 'method':
				$addWhere="where method='".$inputData['method']."'";
				break;
			case 'zonename':
				$addWhere="where zonename='".$inputData['zonename']."'";
				break;
			
		}

		self::remove(array(1),$addWhere);
	}



	public static function insert($inputData=array())
	{
		// End addons

		$addMultiAgrs='';

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d H:i:s');

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
			$zonename=$inputData['zonename'];

			$func=$inputData['func'];

			$path=$inputData['path'];

			$method_call=$inputData['method_call'];

			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where func='$func' AND method_call='$method_call' AND zonename='$zonename' AND path='$path'"
				));

			if(isset($loadData[0]['func']))
			{
				return false;
			}

			$inputData['date_added']=date('Y-m-d H:i:s');

			if(isset($inputData['title']))
			$inputData['title']=String::encode(strip_tags($inputData['title']));

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".Database::getPrefix()."widgets($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/category');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			self::saveCache();


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

		$command="delete from ".Database::getPrefix()."widgets where $whereQuery $addWhere";

		Database::query($command);

		self::saveCache();

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

		if(isset($post['title']))
		{
			$post['title']=String::encode(strip_tags($post['title']));		
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

		Database::query("update ".Database::getPrefix()."widgets set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/category');

		// DBCache::removeCache($listIDs,'system/category');

		if(!$error=Database::hasError())
		{
			self::saveCache();
			
			return true;
		}

		return false;
	}


}