<?php

/*
	Table::setTable('post');

	$result=Table::get($inputData);
*/

class Table
{
	public static $fields='';

	public static $table='';

	public static function setTable($inputData='')
	{
		self::$table=$inputData;
	}

	public static function setFields($inputData='')
	{
		self::$fields=$inputData;
	}

	public static function get($inputData=array(),$callback='')
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$moreFields=isset($inputData['moreFields'])?','.$inputData['moreFields']:'';

		$field=self::$fields.$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		// $prefix=System::getPrefix();
		
		$command="select $selectFields from ".self::$table." $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			$result=Cache::get($md5Query,$cacheTime);

			if($result!=false)
			{
				$result=unserialize($result);

				return $result;
			}
		}

		try {
			$query=Database::query($queryCMD);
		} catch (Exception $e) {
			Alert::make($e->getMessage());
		}
		
		if(isset(Database::$error[5]))
		{
			$result=false;
		}
		else
		{
			$result=array();

			if((int)$query->num_rows > 0)
			{
				while($row=Database::fetch_assoc($query))
				{					
					$result[]=$row;
				}	

				if(is_object($callback))
				{
					$result=$callback($result,$inputData);
				}

				if($cache=='yes')
				{
					Cache::make($md5Query,serialize($result));
				}
				
			}	
		}

		return $result;
	}


	public static function insert($inputData=array(),$beforeInsert='',$afterInsert='')
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(is_object($beforeInsert))
		{
			$inputData=$beforeInsert($inputData);
		}

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".self::$table."($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/page');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			if(is_object($afterInsert))
			{
				$afterInsert($inputData);
			}

			return $id;	
		}

		return false;
	
	}	

	
	public static function remove($inputIDs=array(),$whereQuery='')
	{

		if(!is_array($inputIDs))
		{
			$id=$inputIDs;

			unset($inputIDs);

			$inputIDs=array($id);
		}

		$total=count($inputIDs);

		$listID="'".implode("','",$inputIDs)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$command="delete from ".self::$table." where $whereQuery";

		Database::query($command);	

		return true;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='',$afterUpdate='')
	{

		if(!is_array($listID))
		{
			$catid=(int)$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";


		$setUpdates='';

		$whereQuery='';

		if(isset($updateData['where']))
		{
			$whereQuery=$updateData['where'];

			unset($updateData['where']);
		}	
						
		$keyNames=array_keys($updateData);

		$total=count($updateData);

		if(is_object($beforeUpdate))
		{
			$updateData=$beforeUpdate($updateData);
		}
		elseif(is_string($beforeUpdate) && isset($beforeUpdate[3]))
		{
			$whereQuery=$beforeUpdate;
		}

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$updateData[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);

		if(is_string($beforeUpdate) && isset($beforeUpdate[5]))
		{
			$whereQuery=$beforeUpdate;
		}
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";

		Database::query("update ".self::$table." set $setUpdates where $whereQuery");


		if(!$error=Database::hasError())
		{

			if(is_object($afterUpdate))
			{
				$afterUpdate($updateData);
			}

			return true;
		}

		return false;
	}

	public static function up($keyName='',$total=1,$addWhere='')
	{
		Database::query("update ".self::$table." set $keyName=$keyName+$total where $addWhere");
	}

	public static function down($keyName='',$total=1,$addWhere='')
	{
		Database::query("update ".self::$table." set $keyName=$keyName-$total where $addWhere");
	}


	public static function exists($id)
	{
		$savePath=ROOT_PATH.'caches/system/'.self::$table.'/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			return false;			
		}

		return true;
	}

	public static function loadCache($id,$notExists,$afterCompleted='')
	{
		$savePath=ROOT_PATH.'caches/system/'.self::$table.'/'.$id.'.cache';

		$savePath = strval(str_replace("\0", "", $savePath));

		if(!file_exists($savePath))
		{
			// self::saveCache($id);

			if(is_object($notExists))
			{
				$notExists($id);
			}

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=unserialize(file_get_contents($savePath));

		if(is_object($afterCompleted))
		{
			$loadData=$afterCompleted($loadData);
		}

		return $loadData;

	}

	public static function removeCache($listID)
	{
		
		$savePath=ROOT_PATH.'caches/system/'.self::$table.'/';

		if(!is_array($listID))
		{
			$tmp=$listID;

			$listID=array($tmp);
		}

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 

			$id=$listID[$i];

			$filePath=$savePath.$id.'.cache';

			if(!file_exists($filePath))
			{
				unlink($filePath);			
			}

		}

	}

	public static function saveCache($listID,$beforeCompleted='',$afterCompleted='')
	{

		$savePath=ROOT_PATH.'caches/system/'.self::$table.'/';

		if(!is_array($listID))
		{
			$tmp=$listID;

			$listID=array($tmp);
		}

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			$loadData=self::get(array(
					'cache'=>'no',
					'selectFields'=>'*',
					'where'=>"where id='$id'"
					));	

			if(isset($loadData[$i]['id']))
			{
				if(is_object($beforeCompleted))
				{
					$loadData[$i]=$beforeCompleted($loadData[$i]);
				}

				$filePath=$savePath.$id.'.cache';

				File::create($filePath,serialize($loadData[$i]));

				if(is_object($afterCompleted))
				{
					$loadData[$i]=$afterCompleted($loadData[$i]);
				}
			}
		}
		
	}
}