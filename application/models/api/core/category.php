<?php
function getApi()
{
	$resultData=array('error'=>'ERROR');

	if(!$matches=Uri::match('\/category\/(\w+)'))
	{
		return json_encode($resultData);
	}
	$action=strtolower($matches[1]);

	switch ($action) {
		case 'feed':

			if(!isset($_REQUEST['action']))
			{

				if(!isset($_SESSION['userNodeid']))
				{
					return json_encode($resultData);
				}

				$limitShow=20;

				$limitPage=0;

				$queryData=array(
					'limitShow'=>$limitShow,
					'limitPage'=>$limitPage
					);

	

				$queryData['limitShow']=isset($_REQUEST['limitShow'])?(int)$_REQUEST['limitShow']:$limitShow;
				
				$queryData['limitPage']=isset($_REQUEST['limitPage'])?(int)$_REQUEST['limitPage']:$limitPage;	

				if($matchPage=Uri::match('\/page\/(\d+)'))
				{
					$queryData['limitPage']=$matchPage[1];
				}

				if(isset($_REQUEST['where']))
				{
					$where=strtolower(trim($_REQUEST['where']));

					if(!preg_match('/([a-zA-Z0-9_-]+) (\w+) ([a-zA-Z0-9_-]+)/i', $where,$matchWhere))
					{
						return json_encode($resultData);
					}

					$theField=$matchWhere[1];

					$condition=strtolower($matchWhere[2]);

					$theValue=$matchWhere[3];

					$condition=($condition=='equal')?'=':$condition;
					$condition=($condition=='notequal')?'!=':$condition;
					$condition=($condition=='lessthan')?'<':$condition;
					$condition=($condition=='lessethan')?'<=':$condition;
					$condition=($condition=='greaterthan')?'>':$condition;
					$condition=($condition=='greaterethan')?'>=':$condition;
					$condition=($condition=='like')?'LIKE':$condition;

					$theValue=($condition=='LIKE')?"%$theValue%":$theValue;

					$queryData['where']="where $theField $condition '$theValue'";
				}

				if(isset($_REQUEST['orderby']))
				{
					if(!preg_match('/(\w+) (\w+)/i', $_REQUEST['orderby'],$matchOrderby))
					{
						return json_encode($resultData);
					}

					$queryData['orderby']="order by ".$matchOrderby[1]." ".$matchOrderby[2];
				}

				if(!$getData=Categories::get($queryData))
				{
					return json_encode($resultData);
				}

				return json_encode($getData);
			}
			else
			{
				$rqAction=strtolower(trim($_REQUEST['action']));

				$userid=0;

				$groupid=0;

				if(Session::has('userid')==false)
				{
					if(!isset($_REQUEST['email']) || !isset($_REQUEST['password']))
					{
						return json_encode($resultData);
					}

					$valid=Validator::make(array(
						'email'=>'email|max:150|slashes',
						'password'=>'max:50|slashes'
						));

					if(!$valid)
					{
						return json_encode($resultData);
					}	

					$email=$_REQUEST['email'];

					$password=md5($_REQUEST['password']);

					$userData=Users::get(array(
						'where'=>"where email='$email' AND password='$password'"
						));

					if(!isset($userData[0]['userid']))
					{
						return json_encode($resultData);
					}							

					$userid=$userData[0]['userid'];

					$groupid=$userData[0]['groupid'];

				}

				$userid=Session::get('userid');

				$groupid=Session::get('groupid');

				$userPermission=GlobalCMS::$usergroups;

				// print_r($userPermission);die();

				if((int)$userPermission['can_manage_category']==0)
				{
					return json_encode($resultData);
				}

				switch ($rqAction) {
					case 'insert':
						if((int)$userPermission['can_addnew_category']==0)
						{
							return json_encode($resultData);
						}
						$valid=Validator::make(array(
							'cattitle'=>'slashes',
							'parentid'=>'slashes',
							'sort_order'=>'slashes',
							'status'=>'slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						$postData=array(
							'cattitle'=>Request::get('cattitle'),
							'parentid'=>Request::get('parentid'),
							'sort_order'=>Request::get('sort_order'),
							'status'=>Request::get('status')
							);

						if(!$id=Categories::insert($postData))
						{
							return json_encode($resultData);
						}

						$imgPath='';

						$resultData=array('catid'=>$id);

						return json_encode($resultData);
						break;

					case 'update':
						if((int)$userPermission['can_edit_category']==0)
						{
							return json_encode($resultData);
						}
						$valid=Validator::make(array(
							'send.parentid'=>'slashes',
							'nodeid'=>'slashes',
							'send.cattitle'=>'max:255|slashes',
							'send.sort_order'=>'slashes',
							'send.status'=>'slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						Categories::update(Request::get('catid'),Request::get('send'));

						return json_encode(array('ok'=>'OK'));
						break;

					case 'delete':
						if((int)$userPermission['can_delete_category']==0)
						{
							return json_encode($resultData);
						}
						$valid=Validator::make(array(
							'catid'=>'number|slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						$catid=Request::get('catid');

						$loadData=Categories::get(array(
							'where'=>"where catid='$catid'"
							));

						if(!isset($loadData[0]['catid']))
						{
							return json_encode($resultData);
						}

						Categories::remove(array(Request::get('catid')));

						return json_encode(array('ok'=>'OK'));
						break;

				}
			}
			break;

		default:
			return json_encode($resultData);
			break;				
	}

	// $loadData=Post::get($resultQuery);

	// $loadData=json_encode($loadData);

	// return $loadData;

	return json_encode($resultData);
}

?>