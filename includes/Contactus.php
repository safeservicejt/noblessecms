<?php

class Contactus
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

		$field="contactid,fullname,email,content,date_added,isreaded";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from contactus $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

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

				$row['date_added']=Render::dateFormat($row['date_added']);	

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

		// $result=self::plugin_hook_contact($result);

		return $result;
		
	}	

	private function plugin_hook_contact($inputData=array())
	{
		if(!isset(Plugins::$zoneCaches['process_contactus_content']))
		{
			return $inputData;
		}

		$totalPost=count($inputData);

		$totalPlugin=count(Plugins::$zoneCaches['process_contactus_content']);

		for($i=0;$i<$totalPlugin;$i++)
		{
			$plugin=Plugins::$zoneCaches['process_contactus_content'][$i];

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

	public function insert($inputData=array())
	{
		if(isset($inputData['fullname']))
		{
			$inputData['fullname']=String::encode($inputData['fullname']);
		}		
		if(isset($inputData['content']))
		{
			$inputData['content']=String::encode(strip_tags($inputData['content'],'<p><br>'));
		}		

		$inputData['date_added']=date('Y-m-d h:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Plugins::load('before_insert_contactus',$inputData);

		Database::query("insert into contactus($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['contactid']=$id;

			Plugins::load('after_insert_contactus',$inputData);

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"contactid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from contactus where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['fullname']))
		{
			$post['fullname']=String::encode($post['fullname']);
		}		
		if(isset($post['content']))
		{
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"contactid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update contactus set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>