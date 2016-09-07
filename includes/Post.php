<?php


/*
Magic tag: use in post content

[get_image_url]: thumbnail url of post

*/

class Post
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

		$field="postid,descriptions,title,page_title,catid,userid,parentid,image,sort_order,date_added,views,content,type,keywords,friendly_url,prefix,is_featured,date_featured,expires_date,rating,allowcomment,status,tag_url,category_url,author_url,comments".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by postid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."post $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/post/'.$md5Query,$cacheTime);

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

				if(isset($row['descriptions']))
				{
					$row['descriptions']=String::decode($row['descriptions']);
				}

				if(isset($row['page_title']))
				{
					$row['page_title']=String::decode($row['page_title']);
				}

				if(isset($row['keywords']))
				{
					$row['keywords']=String::decode($row['keywords']);
				}

				if(isset($row['friendly_url']))
				{
					$row['url']=self::url($row);
				}

				if(isset($row['author_url']) && isset($row['author_url'][10]))
				{
					$row['author_url']=unserialize($row['author_url']);	
				}
				
				if(isset($row['tag_url']) && isset($row['tag_url'][10]))
				{
					$row['tag_url']=unserialize($row['tag_url']);		
				}
				
				if(isset($row['category_url']) && isset($row['category_url'][10]))
				{
					$row['category_url']=unserialize($row['category_url']);		
				}

				if(isset($row['image']) && preg_match('/.*?\.(gif|png|jpe?g)/i', $row['image']))
				{
					if(!preg_match('/^http/i', $row['image']))
					{
						$row['imageUrl']=System::getUrl().$row['image'];
					}
					else
					{
						$row['imageUrl']=$row['image'];
					}
					
				}

				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);

					$row['content']=preg_replace('/(\[get_image_url\])/i', System::getUrl().$row['image'], $row['content']);
					// die($row['content']);
				}

				if(isset($row['date_added']))
				{
					$row['date_addedReal']=$row['date_added'];
					
					$row['date_added']=Render::dateFormat($row['date_added']);	
				}
				

				if($inputData['isHook']=='yes' && isset($row['content']))
				{
					$row['content']=String::decode($row['content']);

					$row['content']=html_entity_decode($row['content']);
					
					$row['content']=Shortcode::loadInTemplate($row['content']);

					$row['content']=Shortcode::load($row['content']);
					
					$row['content']=Shortcode::toHTML($row['content']);
					
				}
											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/post/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}

	public static function updateData($postid=0)
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where postid='$postid'"
			));

		$updateData=array();

		if(isset($loadData[0]['postid']))
		{
			$loadTag=PostTags::get(array(
				'cache'=>'no',
				'where'=>"where postid='$postid'"
				));

			if(isset($loadTag[0]['postid']))
			{
				$updateData['tag_url']=serialize($loadTag);
			}

			$loadCat=Categories::get(array(
				'cache'=>'no',
				'where'=>"where catid='".$loadData[0]['catid']."'"
				));

			if(isset($loadCat[0]['catid']))
			{
				$updateData['category_url']=serialize($loadCat);
			}

			$loadUser=Users::get(array(
				'cache'=>'no',
				'where'=>"where userid='".$loadData[0]['userid']."'"
				));

			if(isset($loadUser[0]['userid']))
			{
				$authorData=array();
				
				$authorData['username']=$loadUser[0]['username'];
				$authorData['userid']=$loadUser[0]['userid'];
				$authorData['firstname']=$loadUser[0]['firstname'];
				$authorData['lastname']=$loadUser[0]['lastname'];

				$updateData['author_url']=serialize($authorData);
			}

			self::update($postid,$updateData);

		}
	}

	public static function getImageFromContent($postid=0)
	{
		$theUri=$postid;

		$savePath=ROOT_PATH.'application/caches/images/'.$theUri.'.cache';

		$fileUrl='';

		if(file_exists($savePath))
		{
			$fileUrl=trim(file_get_contents($savePath));
		}
		else
		{

			$loadData=Post::get(array(
				'isHook'=>'no',
				'cache'=>'yes',
				'cacheTime'=>30,
				'where'=>"where postid='$postid'"
				));

			if(!isset($loadData[0]['image']))
			{
				throw new Exception('This post not exists.');
				
			}

			if(!preg_match('/(http[a-zA-Z0-9_\-\.\:\/\(\)\&\@\!\#\$]+\.(jpg|png))/i', $loadData[0]['content'], $matches))
			{
				throw new Exception('Post content not have any image.');
			}

			$image=$matches[1];

			$fileUrl=$image;

			File::create($savePath,$fileUrl);

		}

		return $fileUrl;
	}

	public static function getThumb($postid=0)
	{
		$theUri=$postid;

		$savePath=ROOT_PATH.'application/caches/images/'.$theUri.'.cache';

		$fileUrl='';

		if(file_exists($savePath))
		{
			$fileUrl=trim(file_get_contents($savePath));

		}
		else
		{

			$loadData=Post::get(array(
				'isHook'=>'no',
				'cache'=>'yes',
				'cacheTime'=>30,
				'where'=>"where postid='$postid'"
				));

			if(!isset($loadData[0]['image']))
			{
				throw new Exception('This post not exists.');
				
			}

			if(!file_exists(ROOT_PATH.$loadData[0]['image']))
			{
				throw new Exception('Thumbnail not exists.');
				
			}

			$fileUrl=$loadData[0]['image'];

			File::create($savePath,$fileUrl);

		}

		return $fileUrl;
	}

	public static function url($row)
	{
		$url=Url::post($row);

		return $url;
	}

	public static function api($action)
	{
		Model::load('api/post');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}

	public static function upView($postid)
	{
		Database::query("update ".Database::getPrefix()."post set views=views+1 where postid='$postid'");
	}

	public static function downView($postid)
	{
		Database::query("update ".Database::getPrefix()."post set views=views-1 where postid='$postid'");
	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/post/';

		return $result;
	}	

	public static function saveCache($id)
	{
		$loadData=self::get(array(
			'selectFields'=>'*',
			'isHook'=>'no',
			'cache'=>'no',
			'where'=>"where postid='$id'"
			));
		
		if(isset($loadData[0]['postid']))
		{
			$savePath=ROOT_PATH.'application/caches/fastcache/post/'.$id.'.cache';

			File::create($savePath,serialize($loadData[0]));			
		}

	}

	public static function loadCache($id='')
	{
		$savePath=ROOT_PATH.'application/caches/fastcache/post/'.$id.'.cache';

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

		$total=count($result);

		// print_r($result);die();

		if(isset($result['content']))
		{
			$result['content']=String::decode($result['content']);

			$result['content']=preg_replace('/(\[get_image_url\])/i', System::getUrl().$result['image'], $result['content']);
			// die($result['content']);
		}

		if(isset($result['date_added']))
		{
			$result['date_addedReal']=$result['date_added'];
			
			$result['date_added']=Render::dateFormat($result['date_added']);	
		}
		

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
			'where'=>"where postid IN($parseID)"
			));


		$total=count($loadData);

		$savePath=ROOT_PATH.'application/caches/fastcache/post/';

		for ($i=0; $i < $total; $i++) { 
			$filePath=$savePath.$loadData[$i]['postid'].'.cache';

			if(file_exists($filePath))
			{
				unlink($filePath);
			}
		}
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		Plugins::load('before_post_insert',$inputData);
		
		CustomPlugins::load('before_post_insert');

		$addMultiAgrs='';

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
				
				if(isset($theRow['page_title']))
				{
					$theRow['page_title']=String::encode(strip_tags($theRow['page_title']));
				}
				else
				{
					$theRow['page_title']=$theRow['title'];
				}
				
				if(isset($theRow['descriptions']))
				{
					$theRow['descriptions']=String::encode(strip_tags($theRow['descriptions']));
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

			if(isset($inputData['descriptions']))
			{
				$inputData['descriptions']=String::encode(strip_tags($inputData['descriptions']));
			}

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		


		Database::query("insert into ".Database::getPrefix()."post($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/post');


		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_post_insert',$inputData);


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

		Plugins::load('before_post_remove',$post);

		CustomPlugins::load('before_post_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"postid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."post where $whereQuery $addWhere";


		$result=array();

		$loadData=self::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'selectFields'=>'postid',
			'where'=>"where  $whereQuery $addWhere"
			));

		if(isset($loadData[0]['postid']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$result[]=$loadData[$i]['postid'];
			}

			$listID="'".implode("','",$result)."'";

			Comments::remove(array(0),"postid IN ($listID)");
			
			PostTags::remove(array(0),"postid IN ($listID)");

		}

		Database::query($command);	

		// self::saveCache();

		CustomPlugins::load('after_post_remove',$post);

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

		Plugins::load('before_post_update',$listID);

		CustomPlugins::load('before_post_update',$listID);
				
		if(isset($post['title']))
		{
			$postTitle=isset($post['addTitle'])?$post['addTitle']:$post['title'];

			$post['title']=String::encode(strip_tags($post['title']));
		}

		if(isset($post['friendly_url']))
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where friendly_url='".$post['friendly_url']."' AND postid<>'".$listID[0]."'"
				));

			if(isset($loadData[0]['postid']))
			{
				return false;
			}

		}

		if(isset($post['content']))
		{
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"postid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."post set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{

			// self::saveCache();
			CustomPlugins::load('after_post_update',$listID);

			return true;
		}

		return false;
	}


}