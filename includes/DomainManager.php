<?php

class DomainManager
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

		$field="id,title,domain,content,date_added,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();
		
		$command="select $selectFields from domain_manager $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=Cache::loadKey('dbcache/system/domain_manager/'.$md5Query,$cacheTime);

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
		Cache::saveKey('dbcache/system/domain_manager/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}

	public static function createDB($prefix='')
	{
		if($prefix=='')
		{
			return false;
		}

		$filePath=ROOT_PATH.'contents/plugins/domainmanage/install/fix.sql';

		if(!file_exists($filePath))
		{
			return false;
		}

		$fileData=file_get_contents($filePath);

		if(!isset($fileData[10]))
		{
			return false;
		}

		$replaces=array(
			'/EXISTS `(\w+)`/i'=>'EXISTS `'.$prefix.'$1`',
			'/INSERT INTO `(\w+)`/i'=>'INSERT INTO `'.$prefix.'$1`',

			);

		$fileData=preg_replace(array_keys($replaces), array_values($replaces), $fileData);

		$savePath=ROOT_PATH.'uploads/tmp.sql';

		File::create($savePath,$fileData);

		Database::import($savePath);

		unlink($savePath);

		Database::query("insert into ".$prefix."users(groupid,username,password,email,firstname,lastname) select groupid,username,password,email,firstname,lastname from users");

		$id=Database::insert_id();

		Database::query("insert into ".$prefix."address(userid,firstname,lastname) values('".$id."','James','Browns')");
		
		Database::query("insert into ".$prefix."usergroups(groupid,group_title,groupdata) select groupid,group_title,groupdata from usergroups");

		UserGroups::saveCache($prefix,1);



	}

	public static function removeData($domain='')
	{
		if(!isset($domain[1]))
		{
			return false;
		}

		Dir::remove(ROOT_PATH.'contents/domains/'.$domains.'/');
	}

	public static function saveSetting($domain,$inputData=array())
	{
		$filePath=ROOT_PATH.'contents/domains/';

		if(!is_dir($filePath.$domain))
		{
			return false;
		}

		$filePath.=$domain.'/config.cache';

		if(!file_exists($filePath))
		{
			return false;
		}

		$loadData=unserialize(file_get_contents($filePath));

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$loadData[$keyName]=$inputData[$keyName];
		}

		File::create($filePath,serialize($loadData));
	}

	public static function createOnlyPrefix($domain='',$prefix='',$createdb=0)
	{
		if(!isset($domain[1]))
		{
			return false;
		}

		$insertData=array(
			'prefix'=>$prefix,
			'dbhost'=>'localhost',
			'status'=>1
			);

		self::createDomain($domain,$insertData);

		if((int)$createdb > 0)
		{
			self::createDB($prefix);
		}
	}

	public static function createDomain($domain,$inputData=array())
	{
		if(!isset($inputData['prefix']))
		{
			return false;
		}

		$savePath=ROOT_PATH.'contents/domains/'.$domain;


		File::create($savePath.'/config.cache',serialize($inputData));
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d H:i:s');

				

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


			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into domain_manager($insertKeys) values".$addMultiAgrs);

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from domain_manager where $whereQuery $addWhere";

		Database::query($command);	

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

		Database::query("update domain_manager set $setUpdates where $whereQuery $addWhere");
		
		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>