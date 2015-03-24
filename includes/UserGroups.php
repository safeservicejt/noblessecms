<?php

class UserGroups
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

		$field="groupid,group_title,groupdata";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by groupid desc';

		$result=array();

		// $dbName=Multidb::renderDb('usergroups');

		$command="select $selectFields from usergroups $whereQuery $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($queryCMD);

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		return $result;
		
	}
	public function enable($keyName)
	{
		if(!isset($_SESSION['groupid']) || !isset(GlobalCMS::$usergroups[$keyName]))
		{
			return false;
		}

		$value=GlobalCMS::$usergroups[$keyName];

		$resultData=is_numeric($value)?true:$value;

		return $resultData;
	}
	public function loadCaches()
	{

		// print_r(Session::get('groupid'));die();

		$groupid=Session::get('groupid');

		$password=Cookie::has('password');

		$email=Cookie::has('email');


		// print_r($groupid);die();

		if($groupid==false && $password==false)
		{
			return false;
		}

		if($groupid==false && $email==true && $password==true)
		{
			$email=Cookie::get('email');

			$password=Cookie::get('password');

			// $query=Database::query("select groupid from users where email='$email' AND password='$password'");

			// $total=Database::num_rows($query);

			// if((int)$total == 0)
			// {
			// 	return false;
			// }

			$loadUser=Users::get(array(
				'where'=>"where email='$email' AND password='$password'"
				));

			// $row=Database::fetch_assoc($query);

			if(!isset($loadUser[0]['groupid']))
			{
				return false;
			}

			Session::make('groupid',$loadUser[0]['groupid']);
		}

		if(!$loadData=Cache::loadKey('usergroup_'.$groupid,-1))
		{		
			return false;
		}

		GlobalCMS::$usergroups=json_decode($loadData,true);

		// print_r(GlobalCMS::$usergroups);die();


	}

	public function action($actionName='',$groupid)
	{
		if(!isset(GlobalCMS::$usergroups[$actionName]))
		{
			return false;
		}
		
		switch ($actionName) {
			case 'value':
				# code...
				break;

		}

	}


	public function add($post=array())
	{
		// $nodeid=String::genNode();

		// $inputData['nodeid']=$nodeid;

		$title=trim($post['group_title']);

		if(!isset($title[1]))return false;

		$title=addslashes($title);

		$groupdata=json_encode($post['groupdata']);

		Database::query("insert into usergroups(group_title,groupdata) values('$title','$groupdata')");

		$error=Database::$error;

		if(isset($error[5]))
		{
			return false;
		}

		$id=Database::insert_id();

		// $post['groupid']=$id;

		Cache::saveKey('usergroup_'.$id,$groupdata);
		
		return $id;		
	}


	public function update($id,$post=array())
	{
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);

		Database::query("update usergroups set $setUpdates where groupid='$id'");

		if(!$error=Database::hasError())
		{
			$loadData=self::get(array(
				'where'=>"where groupid='$id'"
				));	

			Cache::saveKey('usergroup_'.$loadData[0]['groupid'],$loadData[0]['groupdata']);		

			return true;
		}

		return false;
	}	

	public function remove($post=array())
	{


		if(is_numeric($post))
		{
			$catid=$post;

			unset($post);

			$post=array($catid);
		}

		$total=count($post);

		for($i=0;$i<$total;$i++)
		{
			Cache::removeKey('usergroup_'.$post[$i]);
		}

		$listID="'".implode("','",$post)."'";

		Database::query("delete from usergroups where groupid in ($listID)");		

		// Database::query("delete from products_pages where pageid in ($listID)");		

		return true;
	}	

}
?>