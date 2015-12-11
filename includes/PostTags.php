<?php

class PostTags
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

		$field="tagid,title,postid";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by tagid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."post_tags $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);
		
		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/posttag/'.$md5Query,$cacheTime);

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
				if(isset($row['title']))
				{
					$row['url']=self::url($row);
				}				
											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}


		
		// Save dbcache
		Cache::saveKey('dbcache/system/posttag/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}

	public static function renderToText($postid)
	{

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where postid='$postid'"
			));

		if(!isset($loadData[0]['postid']))
		{
			return '';
		}


		$total=count($loadData);

		$li='';

		for ($i=0; $i < $total; $i++) { 
			$li.=$loadData[$i]['title'].', ';
		}

		$li=substr($li, 0,strlen($li)-2);

		return $li;
	}
	
	public static function renderToLink($postid)
	{
		$loadData=self::get(array(
			'cache'=>'yes',
			'cacheTime'=>30,
			'where'=>"where postid='$postid'"
			));
		
		if(!isset($loadData[0]['postid']))
		{
			return '';
		}

		$total=count($loadData);

		$li='';
		
		for ($i=0; $i < $total; $i++) { 
			$li.='<a href="'.self::url($loadData[$i]).'">'.$loadData[$i]['title'].'</a>, ';
		}

		$li=substr($li, 0,strlen($li)-2);
	

		return $li;
	}

	public static function url($row)
	{
		$url=Url::tag($row);

		return $url;
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {


				if(isset($theRow['title']))
				$theRow['title']=trim(String::makeFriendlyUrl(strip_tags($theRow['title'])));

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
			if(isset($inputData['title']))
			$inputData['title']=trim(String::makeFriendlyUrl(strip_tags($inputData['title'])));

			if(strlen($inputData['title'])==0)
			{
				return false;
			}

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".Database::getPrefix()."post_tags($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/posttag');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			CustomPlugins::load('after_posttag_insert');

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"tagid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."post_tags where $whereQuery $addWhere";

		Database::query($command);	

		// DBCache::removeDir('system/posttag');

		CustomPlugins::load('after_posttag_remove');
		
		// DBCache::removeCache($listID,'system/posttag');

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"tagid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."post_tags set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/posttag');

		// DBCache::removeCache($listIDs,'system/posttag');

		if(!$error=Database::hasError())
		{
			CustomPlugins::load('after_posttag_update');

			return true;
		}

		return false;
	}


}
?>