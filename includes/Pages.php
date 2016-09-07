<?php

class Pages
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

		$field="pageid,prefix,title,content,image,keywords,descriptions,page_title,page_type,friendly_url,date_added,allowcomment,views,status".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by pageid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."pages $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache

			

			$loadCache=Cache::loadKey('dbcache/system/page/'.$md5Query,$cacheTime);

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
				
				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);
				}
				
				if(isset($row['image']) && preg_match('/.*?\.(gif|png|jpe?g)/i', $row['image']))
				{
					$row['imageUrl']=System::getUrl().$row['image'];
				}

				if(isset($row['friendly_url']))
				{
					$row['url']=self::url($row);
				}

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	

				if($inputData['isHook']=='yes')
				{
					if(isset($row['content']))
					{
						$row['content']=String::decode($row['content']);
						
						$row['content']=html_entity_decode($row['content']);
						
						$row['content']=Shortcode::loadInTemplate($row['content']);

						$row['content']=Shortcode::load($row['content']);
						
						$row['content']=Shortcode::toHTML($row['content']);
						
						
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
		Cache::saveKey('dbcache/system/page/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}
	public static function api($action)
	{
		Model::load('api/pages');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}
	public static function url($row)
	{
		$url=Url::page($row);

		return $url;
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		CustomPlugins::load('before_page_insert');

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {
		    	
		    	if(!isset($theRow['title']))
		    	{
		    		continue;
		    	}

				$theRow['date_added']=date('Y-m-d H:i:s');

				$postTitle=isset($theRow['addTitle'])?$theRow['addTitle']:$theRow['title'];

				if(!isset($theRow['friendly_url']))
				{
					$theRow['friendly_url']=String::makeFriendlyUrl(strip_tags($postTitle));

				}

				$theRow['title']=String::encode(strip_tags($theRow['title']));


				if(isset($theRow['content']))
				{
					// $theRow['content']=Shortcode::toBBCode($theRow['content']);

					$theRow['content']=String::encode($theRow['content']);
				}

				if(isset($theRow['keywords']))
				{
					$theRow['keywords']=String::encode(strip_tags($theRow['keywords']));
				}

				if(isset($theRow['descriptions']))
				{
					$theRow['descriptions']=String::encode(strip_tags($theRow['descriptions']));
				}
				
				if(isset($theRow['page_title']))
				{
					$theRow['page_title']=String::encode(strip_tags($theRow['page_title']));
				}
				else
				{
					$theRow['page_title']=$theRow['title'];
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
			if(!isset($inputData['title']))
			{
				continue;
			}

			$inputData['date_added']=date('Y-m-d H:i:s');

			$postTitle=isset($inputData['addTitle'])?$inputData['addTitle']:$inputData['title'];

			if(!isset($inputData['friendly_url']))
			{
				$inputData['friendly_url']=String::makeFriendlyUrl(strip_tags($postTitle));
			}

			$inputData['title']=String::encode(strip_tags($inputData['title']));

			if(isset($inputData['content']))
			{
				// $inputData['content']=Shortcode::toBBCode($inputData['content']);

				$inputData['content']=String::encode($inputData['content']);
			}

			if(isset($inputData['keywords']))
			{
				$inputData['keywords']=String::encode(strip_tags($inputData['keywords']));
			}

			if(isset($inputData['page_title']))
			{
				$inputData['page_title']=String::encode(strip_tags($inputData['page_title']));
			}
			else
			{
				$inputData['page_title']=$inputData['title'];
			}

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".Database::getPrefix()."pages($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/page');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_page_insert',$inputData);

			return $id;	
		}

		return false;
	
	}

	public static function saveCache($id)
	{
		$loadData=self::get(array(
			'selectFields'=>'*',
			'cache'=>'no',
			'where'=>"where pageid='$id'"
			));

		if(isset($loadData[0]['pageid']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/page/'.$id.'.cache';

			File::create($savePath,serialize($loadData[0]));			
		}

	}

	public static function loadCache($id='')
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/page/'.$id.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				$result=false;
			}

			$result=unserialize(file_get_contents($savePath));
		}

		if(isset($result['title']))
		{
			$result['title']=String::decode($result['title']);
		}
		if(isset($result['page_title']))
		{
			$result['page_title']=String::decode($result['page_title']);
		}
		if(isset($result['keywords']))
		{
			$result['keywords']=String::decode($result['keywords']);
		}
		if(isset($result['descriptions']))
		{
			$result['descriptions']=String::decode($result['descriptions']);
		}
		
		if(isset($result['content']))
		{
			$result['content']=String::decode($result['content']);
		}
		
		if(isset($result['image']) && preg_match('/.*?\.(gif|png|jpe?g)/i', $result['image']))
		{
			$result['imageUrl']=System::getUrl().$result['image'];
		}

		if(isset($result['friendly_url']))
		{
			$result['url']=self::url($result);
		}

		if(isset($result['date_added']))
		$result['date_addedFormat']=Render::dateFormat($result['date_added']);	

		if(isset($result['content']))
		{
			$result['content']=String::decode($result['content']);
			
			$result['content']=html_entity_decode($result['content']);
			
			$result['content']=Shortcode::loadInTemplate($result['content']);

			$result['content']=Shortcode::load($result['content']);
			
			$result['content']=Shortcode::toHTML($result['content']);
			
			
		}	

		return $result;

	}

	public static function removeCache($listID=array())
	{
		$parseID="'".implode("','", $listID)."'";

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where pageid IN($parseID)"
			));


		$total=count($loadData);

		$savePath=ROOT_PATH.'application/caches/fastcache/page/';

		for ($i=0; $i < $total; $i++) { 
			$filePath=$savePath.$loadData[$i]['pageid'].'.cache';

			if(file_exists($filePath))
			{
				unlink($filePath);
			}
		}
	}
	
	public static function remove($post=array(),$whereQuery='',$addWhere='')
	{


		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		CustomPlugins::load('before_page_remove',$post);

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"pageid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."pages where $whereQuery $addWhere";

		Database::query($command);	

		// DBCache::removeDir('system/page');

		CustomPlugins::load('after_page_remove',$post);
		
		// DBCache::removeCache($listID,'system/page');

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

		CustomPlugins::load('before_page_update',$listID);

		$listIDs="'".implode("','",$listID)."'";
				
		if(isset($post['friendly_url']))
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where friendly_url='".$post['friendly_url']."' AND pageid<>'".$listID[0]."'"
				));

			if(isset($loadData[0]['pageid']))
			{
				return false;
			}

		}		

		if(isset($post['content']))
		{
			
			// $post['content']=Shortcode::toBBCode($post['content']);

			$post['content']=String::encode($post['content']);

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
						
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"pageid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."pages set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/page');

		// DBCache::removeCache($listIDs,'system/page');

		if(!$error=Database::hasError())
		{
			CustomPlugins::load('after_page_update',$listID);

			return true;
		}

		return false;
	}


}
?>