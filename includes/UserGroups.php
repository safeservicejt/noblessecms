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

/*
Group Permission

can_view_admincp|yes
can_view_usercp|yes
can_view_homepage|yes
can_view_post|yes
can_insert_comment|yes
can_manage_post|yes
can_addnew_post|yes
can_edit_post|yes
can_remove_post|yes
can_manage_link|yes
can_addnew_link|yes
can_edit_link|yes
can_remove_link|yes
can_addnew_category|yes
can_edit_category|yes
can_remove_category|yes
can_addnew_redirect|yes
can_edit_redirect|yes
can_remove_redirect|yes
can_manage_contactus|yes
can_remove_contactus|yes
can_addnew_page|yes
can_edit_page|yes
can_remove_page|yes
can_addnew_user|yes
can_edit_user|yes
can_remove_user|yes
can_edit_user_group|yes
can_addnew_usergroup|yes
can_edit_usergroup|yes
can_remove_usergroup|yes
can_setting_system|yes
can_manage_plugins|yes
can_manage_themes|yes
can_activate_theme|yes
can_edit_theme|yes
can_setting_theme|yes
can_control_theme|yes
can_import_theme|yes
can_install_plugin|yes
can_control_plugin|yes
can_run_plugin|yes
can_setting_plugin|yes
can_uninstall_plugin|yes
can_activate_plugin|yes
can_deactivate_plugin|yes
can_import_plugin|yes
can_manage_category|yes
can_manage_user|yes
can_manage_usergroup|yes
can_remove_owner_post|yes
default_new_post_status|1
show_category_manager|yes
show_post_manager|yes
show_comment_manager|yes
show_page_manager|yes
show_link_manager|yes
show_user_manager|yes
show_usergroup_manager|yes
show_contact_manager|yes
show_theme_manager|yes
show_plugin_manager|yes
show_setting_manager|yes
show_all_post|yes
can_remove_all_post|yes

*/



class UserGroups
{
	public static $groupData=array();

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

		$field="groupid,group_title,groupdata".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by groupid desc';

		$result=array();

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		$command="select $selectFields from ".$prefix."usergroups $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:15;

		$md5Query=md5($queryCMD);
		
		if($cache=='yes')
		{
			// Load dbcache

			

			$loadCache=Cache::loadKey('dbcache/system/usergroup/'.$md5Query,$cacheTime);

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
		Cache::saveKey('dbcache/system/usergroup/'.$md5Query,serialize($result));
		// end save

		return $result;
		
	}

	public static function api($action)
	{
		Model::load('api/usergroups');

		try {
			loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}	

	public static function loadGroup($groupid)
	{

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}
				
		if(!$loadData=Cache::loadKey($prefix.'userGroup_'.$groupid,-1))
		{
			$loadData=self::get(array(
				'cache'=>'yes',
				'cacheTime'=>30,
				'where'=>"where groupid='$groupid'"
				));

			if(!isset($loadData[0]['groupid']))
			{
				return false;
			}

			$loadData[0]['groupdata']=unserialize(self::lineToArray($loadData[0]['groupdata']));

			self::$groupData=$loadData[0];

			self::saveCache();
		}
		else
		{
			$loadData=unserialize($loadData);

			$loadData['groupdata']=unserialize($loadData['groupdata']);
			
			self::$groupData=$loadData;
		}
	}

	public static function updatePermission($groupid,$inputData=array())
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

	public static function updatePermissionToAll($inputData=array())
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

	public static function removePermissionToAll($inputData=array())
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

	public static function removePermission($groupid,$inputData=array())
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

	public static function addPermissionToAll($inputData=array())
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

	public static function addPermission($groupid,$inputData=array())
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
	
	public static function getPermission($groupid,$keyName='')
	{

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		$loadData=array();

		if(!isset(self::$groupData['groupdata']))
		{

			if(!$loadData=Cache::loadKey($prefix.'userGroup_'.$groupid,-1))
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

			self::$groupData['groupid']=isset(self::$groupData['groupid'])?self::$groupData['groupid']:0;

			if((int)$groupid!=(int)self::$groupData['groupid'])
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

				$groupData=$loadData[0]['groupdata'];		

			}
		}

		$value=isset($groupData[$keyName])?$groupData[$keyName]:false;

		return $value;

	}

	public static function arrayToLine($data)
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

	public static function lineToArray($data)
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


	public static function saveCache($addPrefix='',$important=0)
	{
		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}		

		if((int)$important > 0)
		{
			$prefix=$addPrefix;

			Database::setPrefix($prefix);
			
			Database::setPrefixAll();

		}

		$loadData=self::get(array(
			'cache'=>'no'
			));

		$total=count($loadData);

		for ($i=0; $i < $total; $i++) { 

			if(!isset($loadData[$i]['groupdata']))
			{
				continue;
			}

			$loadData[$i]['groupdata']=self::lineToArray($loadData[$i]['groupdata']);
			Cache::saveKey($prefix.'userGroup_'.$loadData[$i]['groupid'],serialize($loadData[$i]));
		}		
	}

	public static function insert($inputData=array())
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

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		Database::query("insert into ".$prefix."usergroups($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/usergroup');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			self::saveCache();

			CustomPlugins::load('after_usergroup_insert');

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"groupid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		$command="delete from ".$prefix."usergroups where $whereQuery $addWhere";

		Database::query($command);	

		// DBCache::removeDir('system/usergroup');
		
		// DBCache::removeCache($listID,'system/usergroup');

		for ($i=0; $i < $total; $i++) { 

			$id=$post[$i];

			Cache::removeKey($prefix.'userGroup_'.$id);
		}

		self::saveCache();


		CustomPlugins::load('after_usergroup_remove');


		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
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

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		Database::query("update ".$prefix."usergroups set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/usergroup');

		// DBCache::removeCache($listIDs,'system/usergroup');

		if(!$error=Database::hasError())
		{
			self::saveCache();

			CustomPlugins::load('after_usergroup_update');


			return true;
		}

		return false;
	}


}