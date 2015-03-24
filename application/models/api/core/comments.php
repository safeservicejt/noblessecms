<?php
function getApi()
{
	$resultData=array('error'=>'ERROR');

	if(!$matches=Uri::match('\/comments\/(\w+)'))
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

				if($matchPage=Uri::match('\/post\/(\d+)'))
				{
					$postid=$matchPage[1];
					$queryData['where']="where postNodeid='$postid'";
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

				if(!$getData=Comments::get($queryData))
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

				if((int)$userPermission['can_manage_comment']==0)
				{
					return json_encode($resultData);
				}

				switch ($rqAction) {
					case 'insert':

						$valid=Validator::make(array(
							'postNodeid'=>'min:9|slashes',
							'fullname'=>'max:255|slashes',
							'email'=>'max:255|slashes',
							'content'=>'slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						$postData=array(
							'postNodeid'=>Request::get('postNodeid'),
							'fullname'=>Request::get('fullname'),
							'email'=>Request::get('email'),
							'content'=>Request::get('content')
							);

						if(!$id=Comments::insert($postData))
						{
							return json_encode($resultData);
						}

						$imgPath='';

						$resultData=array('nodeid'=>$id);

						return json_encode($resultData);
						break;

					case 'update':

						$valid=Validator::make(array(
							'send.postNodeid'=>'slashes',
							'nodeid'=>'slashes',
							'send.fullname'=>'max:255|slashes',
							'send.content'=>'slashes',
							'send.email'=>'max:255|email|slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						Comments::update(Request::get('nodeid'),Request::get('send'));

						return json_encode(array('ok'=>'OK'));
						break;

					case 'delete':

						$valid=Validator::make(array(
							'nodeid'=>'slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						$commentid=Request::get('nodeid');

						$loadData=Comments::get(array(
							'where'=>"where nodeid='$commentid'"
							));

						if(!isset($loadData[0]['nodeid']))
						{
							return json_encode($resultData);
						}

						Comments::remove(array(Request::get('nodeid')));

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