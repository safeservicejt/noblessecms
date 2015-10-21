<?php

/*

If type is php, you must follow below format if wanna get result from code:

$text='

function ab()
{

	return "ok";
}

return ab();

';

*/

class CallToCode
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

		$field="id,title,type,friendly_url,date_added,content,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();
		
		$command="select $selectFields from ".Database::getPrefix()."calltocode $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=Cache::loadKey('dbcache/system/calltocode/'.$md5Query,$cacheTime);

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
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	


											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		
		// Save dbcache
		Cache::saveKey('dbcache/system/calltocode/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}

	public static function load($str,$inputData=array())
	{
		$result='';

		$filePath=ROOT_PATH.'application/caches/dbcache/system/calltocode/'.Database::getPrefix().$str.'.cache';

		if(!file_exists($filePath))
		{
			return $result;
		}

		$loadData=file_get_contents($filePath);

		$loadData=unserialize($loadData);

		if(!is_array($loadData))
		{
			return $result;
		}

		if($loadData['type']=='php')
		{
			$result=eval('?><?php'.stripslashes($loadData['content']).'?><?php;');
		}
		else
		{
			$result=stripslashes($loadData['content']);
		}

		$totalAttrs=count($inputData);

		if($totalAttrs > 0)
		{
			$keyNames=array_keys($inputData);

			$keyValues=array_values($inputData);

			for ($i=0; $i < $totalAttrs; $i++) { 
				$keyNames[$i]='{'.$keyNames[$i].'}';
			}

			$result=str_replace($keyNames, $keyValues, $result);
		}

		return $result;
	}

	public static function saveCache()
	{
		$loadData=self::get(array(
			'where'=>"where status='1'"
			));

		if(isset($loadData[0]['id']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$uri=md5($loadData[$i]['friendly_url']);

				Cache::saveKey('dbcache/system/calltocode/'.Database::getPrefix().$uri,serialize($loadData[$i]));
			}
		}
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['content']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=System::dateTime();

				if(!isset($theRow['friendly_url'][1]))
				{
					$theRow['friendly_url']=strtolower(String::makeFriendlyUrl(strip_tags($theRow['title'])));
				}


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

			if(!isset($inputData['friendly_url'][1]))
			{
				$inputData['friendly_url']=strtolower(String::makeFriendlyUrl(strip_tags($inputData['title'])));

			}

			if(isset($inputData['title']))
			$inputData['title']=String::encode(strip_tags($inputData['title']));


			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".Database::getPrefix()."calltocode($insertKeys) values".$addMultiAgrs);

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

		$command="delete from ".Database::getPrefix()."calltocode where $whereQuery $addWhere";

		Database::query($command);	

		self::saveCache();

		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		if(isset($post['title']))
		{
			$post['title']=String::encode(strip_tags($post['title']));

			$post['friendly_url']=strtolower(String::makeFriendlyUrl(strip_tags($post['title'])));

			$loadPost=self::get(array(
				'where'=>"where friendly_url='".$post['friendly_url']."'"
				));

			if(isset($loadPost[0]['id']) && $loadPost[0]['id']<>$listID[0])
			{
				return false;
			}
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."calltocode set $setUpdates where $whereQuery $addWhere");
		
		if(!$error=Database::hasError())
		{
			self::saveCache();

			return true;
		}

		return false;
	}


}
?>