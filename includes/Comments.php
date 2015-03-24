<?php

class Comments
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

		$field="commentid,postid,parentid,fullname,email,date_added,isreaded,status,content";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from comments $whereQuery";

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
				if(isset($row['fullname']))
				{
					$row['fullname']=String::decode($row['fullname']);
				}
				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);
				}

				if(isset($row['date_added']))
				$row['date_added']=Render::dateFormat($row['date_added']);	

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
			$result=self::plugin_hook_comment($result);
		}
		
		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save


		return $result;
		
	}	
	private function plugin_hook_comment($inputData=array())
	{
		if(!isset(Plugins::$zoneCaches['process_comment_content']))
		{
			return $inputData;
		}

		
		
		$totalPost=count($inputData);

		$totalPlugin=count(Plugins::$zoneCaches['process_comment_content']);

		for($i=0;$i<$totalPlugin;$i++)
		{
			$plugin=Plugins::$zoneCaches['process_comment_content'][$i];

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

		return $inputData;
	}

	public function isenable()
	{
		if((int)GlobalCMS::$setting['enable_comment']==1)
		{
			return true;
		}

		return false;
	}

	public function insert($inputData=array())
	{

		if(!isset(GlobalCMS::$setting['enable_comment']) || (int)GlobalCMS::$setting['enable_comment']==0)
		{
			return false;
		}

		if(isset($inputData['content']))
		{
			$inputData['content']=strip_tags($inputData['content']);
			$inputData['content']=String::encode($inputData['content']);
		}		
		if(isset($inputData['fullname']))
		{
			$inputData['fullname']=String::encode($inputData['fullname']);
		}		

		$inputData['date_added']=date('Y-m-d h:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Plugins::load('before_insert_comments',$inputData);

		Database::query("insert into comments($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['commentid']=$id;
			
			Plugins::load('after_insert_comments',$inputData);

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"commentid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from comments where $whereQuery $addWhere";

		Database::query($command);	
		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['content']))
		{
			$post['content']=strip_tags($post['content']);
			$post['content']=String::encode($post['content']);
		}		
		if(isset($post['fullname']))
		{
			$post['fullname']=String::encode($post['fullname']);
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"commentid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";


		Database::query("update comments set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>