<?php

class Post
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

		$field="postid,title,catid,userid,parentid,image,sort_order,date_added,views,content,type,keywords,friendly_url,is_featured,date_featured,expires_date,rating,allowcomment,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by postid desc';

		$result=array();
		
		$command="select $selectFields from post $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=DBCache::get($queryCMD,$cacheTime,'system/post');

			if($loadCache!=false)
			{

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
					$row['url']=self::url($row);
				}

				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);

					// die($row['content']);
				}

				if(isset($row['date_added']))
				$row['date_added']=Render::dateFormat($row['date_added']);	

				if($inputData['isHook']=='yes')
				{
					if(isset($row['content']))
					{
						$row['content']=Shortcode::loadInTemplate($row['content']);
						
						$row['content']=Shortcode::toHTML($row['content']);
						
						$row['content']=Shortcode::load($row['content']);
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
		$addPostid='';

		$saveName='';

		$saveName=md5($queryCMD);

		// if(!isset($result[1]) && isset($result[0]['postid']))
		// {
		// 	$saveName=$addPostid.'_'.md5($queryCMD);
		// }
		// else
		// {
		// 	$saveName=md5($queryCMD);
		// }

		DBCache::make($saveName,$result,'system/post');

		// DBCache::makeIDCache($saveName,$result,'postid','system/post');
		// end save


		return $result;
		
	}

	public function url($row)
	{
		$url=Url::post($row);

		return $url;
	}

	public function api($action)
	{
		Model::load('api/post');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}

	public function upView($postid)
	{
		Database::query("update post set views=views+1 where postid='$postid'");
	}

	public function downView($postid)
	{
		Database::query("update post set views=views-1 where postid='$postid'");
	}

	public function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=System::dateTime();

				$theRow['friendly_url']=String::makeFriendlyUrl(strip_tags($theRow['title']));

				if(isset($theRow['title']))
				$theRow['title']=String::encode(strip_tags($theRow['title']));


				if(isset($theRow['content']))
				{
					$theRow['content']=Shortcode::toBBCode($theRow['content']);

					$theRow['content']=String::encode($theRow['content']);
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
			$inputData['date_added']=System::dateTime();

			$inputData['friendly_url']=String::makeFriendlyUrl(strip_tags($inputData['title']));

			if(isset($inputData['title']))
			$inputData['title']=String::encode(strip_tags($inputData['title']));

			if(isset($inputData['content']))
			{
				$inputData['content']=Shortcode::toBBCode($inputData['content']);

				$inputData['content']=String::encode($inputData['content']);
			}

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into post($insertKeys) values".$addMultiAgrs);

		DBCache::removeDir('system/post');
		

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;	
		}

		return false;
	
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

		$command="delete from post where $whereQuery $addWhere";

		Database::query($command);	

		// DBCache::removeDir('system/post');

		DBCache::removeCache($listID,'system/post');

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['title']))
		{
			$post['title']=String::encode(strip_tags($post['title']));

			$post['friendly_url']=String::makeFriendlyUrl(strip_tags($post['title']));

			$loadPost=self::get(array(
				'where'=>"where friendly_url='".$post['friendly_url']."'"
				));

			if(isset($loadPost[0]['postid']) && $loadPost[0]['postid']<>$listID[0])
			{
				return false;
			}
		}		

		if(isset($post['content']))
		{
			
			$post['content']=Shortcode::toBBCode($post['content']);

			$post['content']=String::encode(strip_tags($post['content'],'<p><br>'));

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

		// DBCache::removeDir('system/post');

		DBCache::removeCache($listIDs,'system/post');


		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>