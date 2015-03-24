<?php

class Reviews
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

		$field="reviewid,userid,review_content,date_added,rating,isreaded,status,productid,parentid";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from reviews $whereQuery";

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

		// echo Database::$error;die();

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';
		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['review_content']))
				{
					$row['review_content']=String::decode($row['review_content']);
				}
					
				$row['date_added']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';
				
				if(isset($inputData['isHook']) && $inputData['isHook']=='yes')
				{
					$row['review_content']=Shortcode::load($row['review_content']);
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
			$result=self::plugin_hook_review($result);
		}
		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}
	private function plugin_hook_review($inputData=array())
	{

		if(!isset(Plugins::$zoneCaches['process_review_content']))
		{
			return $inputData;
		}

		$totalPost=count($inputData);

		$totalPlugin=count(Plugins::$zoneCaches['process_review_content']);

		for($i=0;$i<$totalPlugin;$i++)
		{
			$plugin=Plugins::$zoneCaches['process_review_content'][$i];

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
				$tmpStr=$func($inputData[$j]['review_content']);	

				if(isset($tmpStr[1]))
				{
					$inputData[$j]['review_content']=$tmpStr;
				}							
			}

		}

		return $inputData;
	}

	public function getApi()
	{
		
	}


	public function insert($inputData=array())
	{
		if(isset($inputData['review_content']))
		{
			$inputData['review_content']=strip_tags($inputData['review_content']);
			$inputData['review_content']=String::encode($inputData['review_content']);
		}
		
		$inputData['date_added']=date('Y-m-d h:i:s');

		$userid=Session::get('userid',0);
		
		$inputData['userid']=!isset($inputData['userid'])?$userid:$inputData['userid'];

		// $inputData['nodeid']=String::genNode();

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Plugins::load('before_insert_reviews',$inputData);

		Database::query("insert into reviews($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['reviewid']=$id;

			// $inputData['nodeid']=$inputData['nodeid'];
			
			Plugins::load('after_insert_reviews',$inputData);

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"reviewid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
			
		$command="delete from reviews where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='')
	{
		if(isset($post['review_content']))
		{
			$post['review_content']=strip_tags($post['review_content']);
			
			$post['review_content']=String::encode($post['review_content']);
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"reviewid in ($listIDs)";

		Database::query("update reviews set $setUpdates where $whereQuery");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>