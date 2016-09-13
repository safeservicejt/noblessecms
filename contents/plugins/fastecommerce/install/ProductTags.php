<?php

class ProductTags
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

		$field="productid,title,friendly_url,views,product_title,product_friendly_url".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by productid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."product_tags $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/product_tags/'.$md5Query,$cacheTime);

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
				if(isset($row['friendly_url']))
				{
					$row['url']=self::url($row['friendly_url']);
				}
									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/product_tags/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}

	public static function add($id,$tagList='')
	{
		if(!isset($tagList[1]))
		{
			return false;
		}

		$loadData=Products::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($loadData[0]['id']))
		{
			return false;
		}

		$split=explode(',', $tagList);

		$total=count($split);

		for ($i=0; $i < $total; $i++) { 

			$theTag=trim($split[$i]);

			self::insert(array(
				'productid'=>$id,
				'title'=>$theTag,
				'product_title'=>$loadData[0]['title'],
				'product_friendly_url'=>$loadData[0]['url']
				));
		}
	}

	public static function url($friendly_url='')
	{
		$url=System::getUrl().'tag/'.$friendly_url;

		return $url;
	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/product_tags/';

		return $result;
	}	

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."products set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."products set $field=$field-$total $addWhere");
	}
	

	public static function saveCache($friendly_url)
	{
		$loadData=self::get(array(
			'selectFields'=>'*',
			'where'=>"where friendly_url='$friendly_url'"
			));

		if(isset($loadData[0]['friendly_url']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/page/'.$friendly_url.'.cache';

			File::create($savePath,serialize($loadData[0]));			
		}

	}

	public static function loadCache($friendly_url='')
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/page/'.$friendly_url.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCache($friendly_url);

			if(!file_exists($savePath))
			{
				$result=false;
			}
		}

		return $result;

	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_product_tag_insert',$inputData);

		$addMultiAgrs='';

		if(!isset($inputData['friendly_url']))
		{
			$inputData['friendly_url']=String::makeFriendlyUrl(strip_tags($inputData['title']));
		}
		
		$inputData['title']=String::encode(strip_tags($inputData['title']));

		$inputData['product_title']=String::encode(strip_tags($inputData['product_title']));

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."product_tags($insertKeys) values".$addMultiAgrs);


		if(!$error=Database::hasError())
		{
			CustomPlugins::load('after_product_tag_insert',$inputData);

			return true;
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

		CustomPlugins::load('before_product_tag_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"productid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."product_tags where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_product_tag_remove',$post);

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listID,'system/post');

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

		CustomPlugins::load('before_product_tag_update',$listID);
				
	
		if(isset($post['title']))
		{
			$postTitle=isset($post['addTitle'])?$post['addTitle']:$post['title'];

			$post['title']=String::encode(strip_tags($post['title']));
		}
	
		if(isset($post['product_title']))
		{
			$post['product_title']=String::encode(strip_tags($post['product_title']));
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"productid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."product_tags set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_product_tag_update',$listID);

			return true;
		}

		return false;
	}


}