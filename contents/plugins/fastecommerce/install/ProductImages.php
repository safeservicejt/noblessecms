<?php

class ProductImages
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

		$field="id,productid,image,sort_order".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by productid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."product_images $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/product_images/'.$md5Query,$cacheTime);

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
				if(isset($row['image']))
				{
					$row['url']=System::getUrl().$row['image'];
				}

									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/product_images/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}

	public static function add($id,$inputName='images')
	{
		$loadData=Products::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($loadData[0]['id']))
		{
			return false;
		}
	
		$result=File::uploadMultiple($inputName,'uploads/files/',$loadData[0]['title']);

		if(is_array($result))
		{
			$total=count($result);

			for ($i=0; $i < $total; $i++) { 

				self::insert(array(
					'productid'=>$id,
					'image'=>$result[$i],
					'sort_order'=>$i
					));
				
			}
		}	
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."product_images set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."product_images set $field=$field-$total $addWhere");
	}	

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/product_images/';

		return $result;
	}	

	public static function saveCache()
	{
		
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_product_image_insert',$inputData);

		$addMultiAgrs='';

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."product_images($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();
			
			CustomPlugins::load('after_product_image_insert',$inputData);

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

		CustomPlugins::load('before_product_image_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"productid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."product_images where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_product_image_remove',$post);

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

		CustomPlugins::load('before_product_image_update',$listID);
				
				
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

		Database::query("update ".Database::getPrefix()."product_images set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_product_image_update',$listID);

			return true;
		}

		return false;
	}


}