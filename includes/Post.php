<?php

class Post
{
	private static $postData=array();

	private static $postid=0;

	private static $isGet='no';

	private static $categories=array();

	private static $totalPost=0;
	
	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="postid,title,post_type,allowcomment,catid,userid,parentid,image,sort_order,date_added,views,content,keywords,friendly_url,pageid,is_featured,date_featured,status,isreaded";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();		
		$command="select $selectFields from post $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';

		// self::category();

		$catid=0;

		$cattitle='';


		// Load dbcache
		$loadCache=DBCache::get($queryCMD);

		if($loadCache!=false)
		{
			return $loadCache;
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

				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}
				if(isset($row['keywords']))
				{
					$row['keywords']=String::decode($row['keywords']);
				}
				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);
				}

				if(isset($row['image']))
				{
					$row['imageUrl']=Render::thumbnail($row['image']);
				}

				$cattitle='';	
							
				$row['date_added']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';

				if(isset($row['friendly_url']))
				{
					$row['url']=Url::post($row);
				}
				

				// $row['cattitle']='';

				// $row['caturl']='';	

				// if(isset($row['catid']))
				// {
				// 	$catid=$row['catid'];

				// 	if(isset(self::$categories[$catid]))
				// 	{
				// 		$cattitle=self::$categories[$catid]['cattitle'];

				// 		$row['cattitle']=$cattitle;

				// 		$row['caturl']=self::$categories[$catid]['url'];	
				// 	}					
				// }


				if(isset($inputData['isHook']) && $inputData['isHook']=='yes')
				{	
					if(isset($row['content']))
					$row['content']=Shortcode::load($row['content']);
				}

				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		if(isset($inputData['isHook']) && $inputData['isHook']=='yes')
		{

			$result=self::plugin_hook_post($result);

		}

		// Save dbcache
		// print_r($result);
		// die();
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}



	private function plugin_hook_post($inputData=array())
	{
		$totalPost=count($inputData);

		if(isset(Plugins::$zoneCaches['process_post_title']))
		{

			$totalPlugin=count(Plugins::$zoneCaches['process_post_title']);

			for($i=0;$i<$totalPlugin;$i++)
			{
				$plugin=Plugins::$zoneCaches['process_post_title'][$i];

				$foldername=$plugin[$i]['foldername'];

				$func=$plugin[$i]['func'];

				$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

				if(!file_exists($pluginPath))
				{
					continue;
				}

				if(!function_exists($func))
				{
					require($pluginPath);
				}
				$tmpStr='';
				for($j=0;$j<$totalPost;$j++)
				{
					$tmpStr=$func($inputData[$j]['title']);

					if(isset($tmpStr[1]))
					{
						$inputData[$j]['title']=$tmpStr;
					}				
				}

			}


		}

		if(isset(Plugins::$zoneCaches['process_post_content']))
		{

			$totalPlugin=count(Plugins::$zoneCaches['process_post_content']);

			for($i=0;$i<$totalPlugin;$i++)
			{
				$plugin=Plugins::$zoneCaches['process_post_content'][$i];

				$foldername=$plugin[$i]['foldername'];

				$func=$plugin[$i]['func'];

				$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

				if(!file_exists($pluginPath))
				{
					continue;
				}

				if(!function_exists($func))
				{
					require($pluginPath);
				}
				$tmpStr='';
				for($j=0;$j<$totalPost;$j++)
				{
					$tmpStr=$func($inputData[$j]['content']);	

					if(isset($tmpStr[1]))
					{
						$inputData[$j]['content']=$tmpStr;
					}							
				}

			}

		}

		return $inputData;
	}

	// public function category()
	// {
	// 	$totalCat=count(self::$categories);

	// 	if((int)$totalCat == 0)
	// 	{
	// 		$loadData=Categories::get();	

	// 		$totalCat=count($loadData);

	// 		for($i=0;$i<$totalCat;$i++)
	// 		{
	// 			$catid=$loadData[$i]['catid'];

	// 			self::$categories[$catid]=$loadData[$i];
	// 		}


	// 	}
	// }

	public function tags($id)
	{
		$loadData=PostTags::get(array(
			'where'=>"where postid='$id'"
			));

		return $loadData;
	}

	public function comments($id)
	{
		$loadData=Comments::get(array(
			'where'=>"where postid='$id'"
			));

		return $loadData;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);
		}
		
		if(isset($post['keywords']))
		{
			$post['keywords']=String::encode($post['keywords']);
		}

		if(isset($post['content']))
		{
			$post['content']=Shortcode::toBBcode($post['content']);
			
			$post['content']=strip_tags($post['content']);
			
			$post['content']=String::encode($post['content']);
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"postid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update post set $setUpdates where $whereQuery $addWhere");

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"postid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="select image from post where postid in ($listID)";

		$query=Database::query($command);

		while($row=Database::fetch_assoc($query))
		{
			$thumbnail=ROOT_PATH.$row['image'];

			if(!is_dir($thumbnail) && file_exists($thumbnail))
			{
				unlink($thumbnail);

				$thumbnail=dirname($thumbnail);

				rmdir($thumbnail);
			}
		}		

		$command="delete from post where $whereQuery $addWhere";

		Database::query($command);	
		
		// PostImages::remove($post);
		
		Postmeta::remove($post);

		PostTags::remove($post);

		return true;
	}

	public function insert($inputData=array())
	{
		$inputData['friendly_url']=String::encode(Url::makeFriendly($inputData['title']));

		if(isset($inputData['title']))
		{
			$inputData['title']=String::encode($inputData['title']);
		}
		if(isset($inputData['keywords']))
		{
			$inputData['keywords']=String::encode($inputData['keywords']);
		}

		if(isset($inputData['content']))
		{
			$inputData['content']=Shortcode::toBBcode($inputData['content']);

			$inputData['content']=strip_tags($inputData['content']);

			$inputData['content']=String::encode($inputData['content']);
		}

		if(!isset($inputData['catid']))
		{
			$loadCat=Categories::get(array(
				'limitShow'=>1,
				'orderby'=>'order by date_added'
				));

			if(isset($loadCat[0]['catid']))
			{
				$inputData['catid']=$loadCat[0]['catid'];
			}
		}


		if(Session::has('userid'))
		{
			$inputData['userid']=Session::get('userid');
		}

				
		$inputData['date_added']=date('Y-m-d h:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Plugins::load('before_insert_post',$inputData);

		Database::query("insert into post($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			// Multidb::increasePost();
			// self::saveTotal();

			$inputData['postid']=$id;

			Plugins::load('after_insert_post',$inputData);

			Database::query("update post set sort_order='$id' where postid='$id'");	

			return $id;	
		}

		return false;
	}

	public function insertTags($id,$tagStr='')
	{
		if(!isset($tagStr[1]))
		{
			return false;
		}

		$loadData=array();

		if(preg_match('/\,/i', $tagStr))
		{
			$listTags=explode(',', $tagStr);

			$total=count($listTags);	

			for($i=0;$i<$total;$i++)
			{
				$loadData[$i]['tag_title']=trim($listTags[$i]);

				$loadData[$i]['postid']=$id;
			}		
		}
		else
		{
			$loadData[0]['tag_title']=trim($tagStr);
			$loadData[0]['postid']=$id;			
		}

		$totalTag=count($loadData);

		$theTag='';

		PostTags::remove(array($id));

		for($i=0;$i<$totalTag;$i++)
		{
			$theTag=$loadData[$i]['tag_title'];

			if(preg_match('/\'|\"|\//', $theTag))
			{
				continue;
			}

			PostTags::insert($loadData[$i]);
		}

	}	



}

?>