<?php

class Links
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

		$field="id,parentid,date_added,title,url,status,sort_order".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."links $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=Cache::loadKey('dbcache/system/link/'.$md5Query,$cacheTime);

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
				$row['title']=String::decode($row['title']);	

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	

				if(isset($row['url']))
				{
					
					if(!preg_match('/^http/i',$row['url']))
					{
						$row['urlFormat']=System::getUrl().$row['url'];
					}
					else
					{
						$row['urlFormat']=$row['url'];
					}

					if(preg_match('/^\/(.*?)$/i', $row['url'],$matches))
					{
						$tmp=$matches[1];

						$row['urlFormat']=System::getUrl().$tmp;
					}

					
				}
											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		
		// Save dbcache
		Cache::saveKey('dbcache/system/link/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}


	public static function saveCache()
	{
		$loadData=self::get(array(
			'orderby'=>'order by sort_order asc'
			));

		if(isset($loadData[0]['id']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/listLinks.cache';

			File::create($savePath,serialize($loadData));			
		}

	}

	public static function loadCache()
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/listLinks.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}

		return $result;

	}	

	public static function getRecursive()
	{
		$loadData=self::get(array(
			'cache'=>'yes',
			'cacheTime'=>230,
			'orderby'=>'order by sort_order desc'
			));

		$result=array();


		if(isset($loadData[0]['id']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 

				if(!isset($loadData[$i]))
				{
					continue;
				}

				$parentid=$loadData[$i]['parentid'];

				$id=$loadData[$i]['id'];

				if((int)$parentid==0)
				for ($j=0; $j < $total; $j++) { 

					if(!isset($loadData[$j]))
					{
						continue;
					}					

					$child_parentid=$loadData[$j]['parentid'];

					$child_id=$loadData[$j]['id'];

					if((int)$id==(int)$child_parentid)
					{
						$loadData[$i]['child'][]=$loadData[$j];

						unset($loadData[$j]);
					}
				}
			}
		}
		else
		{
			return $loadData;
		}

		return $loadData;
	}


	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['content']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d H:i:s');

				if(isset($theRow['title']))
				{
					$theRow['title']=String::encode($theRow['title']);
				}

				if(isset($theRow['url']))
				{
					if(!preg_match('/^\/.*?/i', $theRow['url']) && !preg_match('/^http/i', $inputData['url']))
					{
						$theRow['url']='/'.$theRow['url'];
					}
					
					$theRow['url']=String::encode($theRow['url']);
				}

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


			if(isset($inputData['title']))
			{
				$inputData['title']=String::encode($inputData['title']);
			}
			if(isset($inputData['url']))
			{
				if(!preg_match('/^\/.*?/i', $inputData['url']) && !preg_match('/^http/i', $inputData['url']))
				{
					$inputData['url']='/'.$inputData['url'];
				}

				$inputData['url']=String::encode($inputData['url']);
			}

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".Database::getPrefix()."links($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/link');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_link_insert',$inputData);

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

		$command="delete from ".Database::getPrefix()."links where $whereQuery $addWhere";

		Database::query($command);

		// DBCache::removeDir('system/link');
		
		// DBCache::removeCache($listID,'system/link');

		CustomPlugins::load('after_link_remove',$post);

		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		// if(isset($post['content']))
		// {
			
		// 	$post['content']=Shortcode::toBBCode($post['content']);

		// 	$post['content']=String::encode(strip_tags($post['content'],'<p><br>'));

		// }

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

		Database::query("update ".Database::getPrefix()."links set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/link');

		// DBCache::removeCache($listIDs,'system/link');

		if(!$error=Database::hasError())
		{
			CustomPlugins::load('after_link_update',$listID);

			return true;
		}

		return false;
	}


}
?>