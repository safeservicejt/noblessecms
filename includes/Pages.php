<?php

class Pages
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

		$field="pageid,page_type,title,content,keywords,friendly_url,views,allowcomment,date_added,isreaded,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from pages $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

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

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}				
				$row['url']=Url::page($row);	

				if(isset($inputData['isHook']) && $inputData['isHook']=='yes')
				{
					
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
			$result=self::plugin_hook_page($result);
		}
		
		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}
	private function plugin_hook_page($inputData=array())
	{
		$totalPost=count($inputData);

		if(isset(Plugins::$zoneCaches['process_page_title']))
		{
			if(isset(Plugins::$zoneCaches['process_page_title']))
			{
				$totalPlugin=count(Plugins::$zoneCaches['process_page_title']);

				for($i=0;$i<$totalPlugin;$i++)
				{
					$plugin=Plugins::$zoneCaches['process_page_title'][$i];

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
		}


		if(isset(Plugins::$zoneCaches['process_page_content']))
		{
			$totalPlugin=count(Plugins::$zoneCaches['process_page_content']);

			for($i=0;$i<$totalPlugin;$i++)
			{
				$plugin=Plugins::$zoneCaches['process_page_content'][$i];

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

	public function add($post=array())
	{
		$title=trim($post['title']);

		if(!isset($title[1]))return false;


		$title=$post['title'];

		$post['friendly_url']=Url::makeFriendly($post['title']);

		if(isset($post['content']))
		{
			$post['content']=Shortcode::toBBcode($post['content']);

			$post['content']=strip_tags($post['content']);

			$post['content']=String::encode($post['content']);
		}		
		if(isset($post['keywords']))
		{
			$post['keywords']=String::encode($post['keywords']);
		}		
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);
		}		

		$date_added=date('Y-m-d h:i:s');

		$friendly_url=$post['friendly_url'];

		$content=$post['content'];

		$keywords=$post['keywords'];

		// $title=addslashes($title);

		// $friendly_url=trim($post['friendly_url']);

		// $content=addslashes(trim($post['content']));

		// $keywords=addslashes(trim($post['keywords']));

		Plugins::load('before_insert_page',$post);

		Database::query("insert into pages(title,friendly_url,content,keywords,date_added) values('$title','$friendly_url','$content','$keywords','$date_added')");

		$error=Database::$error;

		if(isset($error[5]))
		{
			return false;
		}

		$id=Database::insert_id();

		$post['pageid']=$id;
		
		Plugins::load('after_insert_page',$post);

		return $nodeid;		
	}


	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['content']))
		{
			$post['content']=Shortcode::toBBcode($post['content']);

			$post['content']=strip_tags($post['content']);
						
			$post['content']=String::encode($post['content']);
		}		
		if(isset($post['keywords']))
		{
			$post['keywords']=String::encode($post['keywords']);
		}		
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);	
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"pageid IN ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update pages set $setUpdates where $whereQuery $addWhere");

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
			$catid=$post;

			unset($post);

			$post=array($catid);
		}

		$total=count($post);
		// print_r($post);die();

		$listID="'".implode("','",$post)."'";
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"pageid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
	

		$command="delete from pages where $whereQuery $addWhere";	

		Database::query($command);	

		return true;
	}	
}
?>