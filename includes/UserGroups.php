<?php


/*
UserGroups::addPermission($_SESSION['userid'],array(
	'can_view_me'=>'no'
	));

UserGroups::removePermission($_SESSION['userid'],array(
	'can_view_me'
	));

UserGroups::addPermissionToAll(array(
	'can_view_me'=>'no'
	));

UserGroups::updatePermissionToAll(array(
	'can_view_me'=>'no'
	));	

UserGroups::removePermissionToAll(array(
	'can_view_me'
	));	

$text=UserGroups::getPermission($_SESSION['userid'],'can_view_me');
*/



class UserGroups
{
	public static $groupData=array();

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="groupid,group_title,groupdata";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by groupid desc';

		$result=array();
		
		$command="select $selectFields from usergroups $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:15;

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=DBCache::get($queryCMD,$cacheTime,'system/usergroup');

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

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	

				if(isset($row['groupdata']))
				$row['groupdata']=self::arrayToLine($row['groupdata']);
											
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

		// if(!isset($result[1]) && isset($result[0]['groupid']))
		// {
		// 	$saveName=$addPostid.'_'.md5($queryCMD);
		// }
		// else
		// {
		// 	$saveName=md5($queryCMD);
		// }

		DBCache::make($saveName,$result,'system/usergroup');

		// DBCache::makeIDCache($saveName,$result,'groupid','system/usergroup');		
		// end save

		return $result;
		
	}

	public function api($action)
	{
		Model::load('api/usergroups');

		try {
			loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}	
	public function loadGroup($groupid)
	{
		if(!$loadData=Cache::loadKey('userGroup1_'.$groupid,-1))
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where groupid='$groupid'"
				));

			if(!isset($loadData[0]['groupid']))
			{
				return false;
			}

			$loadData[0]['groupdata']=unserialize(self::lineToArray($loadData[0]['groupdata']));

			self::$groupData=$loadData[0];
		}
	}

	public function updatePermission($groupid,$inputData=array())
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where groupid='$groupid'"
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		if(!is_array($loadData[0]['groupdata']))
		{
			$loadData[0]['groupdata']=unserialize(self::lineToArray($loadData[0]['groupdata']));

		}

		$total=count($inputData);

		$listKeys=array_keys($inputData);

		// print_r($loadData);die();

		for ($i=0; $i < $total; $i++) { 
			$theKey=$listKeys[$i];

			$loadData[0]['groupdata'][$theKey]=$inputData[$theKey];

		}
		
		$loadData[0]['groupdata']=self::arrayToLine($loadData[0]['groupdata']);

		$updateData=array(
			'groupdata'=>$loadData[0]['groupdata']
			);

		self::update($groupid,$updateData);		

	}

	public function updatePermissionToAll($inputData=array())
	{
		$loadData=self::get(array(
			'cache'=>'no'
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		$total=count($loadData);

		$totalKeys=count($inputData);

		$listKeys=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 

			$row=$loadData[$i];

			$groupid=$row['groupid'];

			if(!is_array($row['groupdata']))
			{
				$row['groupdata']=unserialize(self::lineToArray($row['groupdata']));
			}

			// print_r($loadData);die();

			for ($j=0; $j < $totalKeys; $j++) { 
				$theKey=$listKeys[$j];

				$row['groupdata'][$theKey]=$inputData[$theKey];

			}
			
			$row['groupdata']=self::arrayToLine($row['groupdata']);

			$updateData=array(
				'groupdata'=>$row['groupdata']
				);

			self::update($groupid,$updateData);
		}

		

	}

	public function removePermissionToAll($inputData=array())
	{
		$loadData=self::get(array(
			'cache'=>'no'
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		$total=count($loadData);

		$totalKeys=count($inputData);

		for ($i=0; $i < $total; $i++) { 

			$row=$loadData[$i];

			$groupid=$row['groupid'];

			$groupdata=unserialize(self::lineToArray($row['groupdata']));

			// $listKeys=array_keys($inputData);

			for ($j=0; $j < $totalKeys; $j++) { 

				$keyName=$inputData[$j];

				// $groupdata[$keyName]=$inputData[$keyName];

				if(isset($groupdata[$keyName]))
				{
					unset($groupdata[$keyName]);
				}
			}

			// $groupdata=serialize(self::arrayToLine($groupdata));
			$groupdata=self::arrayToLine($groupdata);

			$updateData=array(
				'groupdata'=>$groupdata
				);

			self::update($groupid,$updateData);
		}


	}

	public function removePermission($groupid,$inputData=array())
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where groupid='$groupid'"
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		$total=count($inputData);

		if($total==0)
		{
			return false;
		}

		$groupdata=unserialize(self::lineToArray($loadData[0]['groupdata']));

		// $listKeys=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$inputData[$i];

			// $groupdata[$keyName]=$inputData[$keyName];

			if(isset($groupdata[$keyName]))
			{
				unset($groupdata[$keyName]);
			}
		}

		// $groupdata=serialize(self::arrayToLine($groupdata));
		$groupdata=self::arrayToLine($groupdata);

		$updateData=array(
			'groupdata'=>$groupdata
			);

		self::update($groupid,$updateData);
	}

	public function addPermissionToAll($inputData=array())
	{
		$loadData=self::get(array(
			'cache'=>'no'
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		$total=count($loadData);

		$totalKey=count($inputData);

		$listKeys=array_keys($inputData);

		if($total==0)
		{
			return false;
		}

		for ($i=0; $i < $total; $i++) { 

			$row=$loadData[$i];

			$groupid=$row['groupid'];

			$groupdata=unserialize(self::lineToArray($row['groupdata']));


			// print_r($groupdata);die();

			for ($j=0; $j < $totalKey; $j++) { 
				$keyName=$listKeys[$j];

				$groupdata[$keyName]=$inputData[$keyName];
			}

			// $groupdata=serialize(self::arrayToLine($groupdata));
			$groupdata=self::arrayToLine($groupdata);

			$updateData=array(
				'groupdata'=>$groupdata
				);

			self::update($groupid,$updateData);

		}


	}

	public function addPermission($groupid,$inputData=array())
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where groupid='$groupid'"
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		$total=count($inputData);

		if($total==0)
		{
			return false;
		}

		$groupdata=unserialize(self::lineToArray($loadData[0]['groupdata']));

		$listKeys=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$listKeys[$i];

			$groupdata[$keyName]=$inputData[$keyName];
		}

		// $groupdata=serialize(self::arrayToLine($groupdata));
		$groupdata=self::arrayToLine($groupdata);

		$updateData=array(
			'groupdata'=>$groupdata
			);

		self::update($groupid,$updateData);
	}
	
	public function getPermission($groupid,$keyName='')
	{
		$loadData=array();

		if(!isset(self::$groupData['groupdata']))
		{

			if(!$loadData=Cache::loadKey('userGroup_'.$groupid,-1))
			{
				$loadData=self::get(array(
					'cache'=>'no',
					'where'=>"where groupid='$groupid'"
					));

				if(!isset($loadData[0]['groupid']))
				{
					return false;
				}

				$loadData[0]['groupdata']=unserialize(self::lineToArray($loadData[0]['groupdata']));

				$loadData=$loadData[0];
			}
			else
			{
				$loadData=unserialize($loadData);

				$loadData['groupdata']=unserialize($loadData['groupdata']);
			}

			self::$groupData=$loadData;	

			$groupData=$loadData['groupdata'];		
		}
		else
		{
			$groupData=self::$groupData['groupdata'];
		}

		$value=isset($groupData[$keyName])?$groupData[$keyName]:false;

		return $value;

	}

	public function arrayToLine($data)
	{
		if(!is_array($data))
		{
			if(!isset($data[5]))
			{
				return '';
			}			
			$data=unserialize($data);
		}


		$total=count($data);

		$listKeys=array_keys($data);

		$li='';

		for ($i=0; $i < $total; $i++) { 
			$theKey=$listKeys[$i];

			$theValue=$data[$theKey];

			$li.=$theKey.'|'.$theValue."\r\n";
		}

		return $li;

	}

	public function lineToArray($data)
	{
		$data=trim($data);

		$resultData=array();

		$parse=explode("\r\n", $data);

		if(!isset($parse[0][1]))
		{
			return '';
		}


		$total=count($parse);

		for ($i=0; $i < $total; $i++) { 

			if(!isset($parse[$i][5]))
			{
				continue;
			}

			$theLine=explode('|', $parse[$i]);

			if(!isset($theLine[1]))
			{
				continue;
			}

			$theKey=trim($theLine[0]);

			$theValue=trim($theLine[1]);

			$resultData[$theKey]=$theValue;
		}

		$resultData=serialize($resultData);



		return $resultData;
	}

	public function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		//groupdata: can_edit_post|yes/no
		//				can_loggedin_to_admincp|yes/no
		//				can_view_front_end|yes/no



		$addMultiAgrs='';

		if(isset($inputData[0]['group_title']))
		{
		    foreach ($inputData as $theRow) {

		    	$theRow['groupdata']=self::lineToArray($theRow['groupdata']);

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
			$inputData['groupdata']=self::lineToArray($inputData['groupdata']);

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into usergroups($insertKeys) values".$addMultiAgrs);

		DBCache::removeDir('system/usergroup');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['groupdata']=self::lineToArray($inputData['groupdata']);

			Cache::saveKey('userGroup_'.$id,serialize($inputData));

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"groupid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from usergroups where $whereQuery $addWhere";

		Database::query($command);	

		// DBCache::removeDir('system/usergroup');
		
		DBCache::removeCache($listID,'system/usergroup');

		for ($i=0; $i < $total; $i++) { 

			$id=$post[$i];

			Cache::removeKey('userGroup_'.$id);
		}

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		if(isset($post['groupdata']) && !is_array($post['groupdata']))
		{
			$post['groupdata']=self::lineToArray($post['groupdata']);
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"groupid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update usergroups set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/usergroup');

		DBCache::removeCache($listIDs,'system/usergroup');

		if(!$error=Database::hasError())
		{
			$loadData=self::get(array(
				'where'=>"where groupid IN ($listIDs)"
				));

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 

				$loadData[$i]['groupdata']=self::lineToArray($loadData[$i]['groupdata']);
				Cache::saveKey('userGroup_'.$loadData[$i]['groupid'],serialize($loadData[$i]));
			}

			return true;
		}

		return false;
	}


}
?>