<?php

class Manufacturers
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

		$field="mid,title,friendly_url,image,date_added";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by mid desc';

		$result=array();
		
		$command="select $selectFields from manufacturers $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);
		
		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=Cache::loadKey('dbcache/system/manufacturer/'.$md5Query,$cacheTime);

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
		Cache::saveKey('dbcache/system/manufacturer/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=System::dateTime();

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
			$inputData['date_added']=System::dateTime();

			if(isset($inputData['title']))
			$inputData['title']=String::encode(strip_tags($inputData['title']));

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into manufacturers($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"mid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from manufacturers where $whereQuery $addWhere";

		Database::query($command);	

		// DBCache::removeDir('system/manufacturer');
		
		DBCache::removeCache($listID,'system/manufacturer');

		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['title']))
		{
			$post['title']=String::encode(strip_tags($post['title']));
		}		

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"mid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update manufacturers set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/manufacturer');

		DBCache::removeCache($listIDs,'system/manufacturer');

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>