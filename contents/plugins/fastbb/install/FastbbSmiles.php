<?php

class FastbbSmiles
{
	
	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="smileid,filename,date_added,code,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();		
		$command="select $selectFields from fastbb_smiles $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';

		// self::category();

		$catid=0;

		$cattitle='';

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:15;

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=DBCache::get($queryCMD,$cacheTime);

			if($loadCache!=false)
			{
				return $loadCache;
			}

			// end load			
		}

		// end load

		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		$total=Database::num_rows($query);

		if((int)$total > 0)
		{
			while($row=Database::fetch_assoc($query))
			{

				if(isset($row['filename']))
				{
					$row['filename']=String::decode($row['filename']);
				}
				$cattitle='';	
							
				$row['date_addedFormat']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';

				if(isset($row['filename']))
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
		// print_r($result);
		// die();
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}


	public function url($row=array(0))
	{
		if(!isset($row['forumid']) || !isset($row['friendly_url']))
		{
			return '';
		}

		$resultData=ROOT_URL.'forum/forum_'.$row['friendly_url'].'.html';

		return $resultData;
	}




	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['filename']))
		{
			$post['filename']=String::encode($post['filename']);

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"forumid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update fastbb_smiles set $setUpdates where $whereQuery $addWhere");

		if(isset(Database::$error[5]))
		{
			return false;
		}

		return true;
	}

	public function remove($post=array(),$whereQuery='',$addWhere='')
	{
		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"forumid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		// $command="select image from fastbb_smiles where forumid in ($listID)";

		// $query=Database::query($command);

		// while($row=Database::fetch_assoc($query))
		// {
		// 	$thumbnail=ROOT_PATH.$row['image'];

		// 	if(!is_dir($thumbnail) && file_exists($thumbnail))
		// 	{
		// 		unlink($thumbnail);

		// 		$thumbnail=dirname($thumbnail);

		// 		rmdir($thumbnail);
		// 	}
		// }		

		$command="delete from fastbb_smiles where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function insert($inputData=array())
	{

		if(isset($inputData['filename']))
		{
			$inputData['filename']=String::encode($inputData['filename']);
		}
				
		$inputData['date_added']=date('Y-m-d H:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into fastbb_smiles($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;	
		}

		return false;
	}


}

?>