<?php
function getApi()
{
	$resultData=array('error'=>'ERROR');

	if(!$matches=Uri::match('\/post\/(\w+)'))
	{
		return json_encode($resultData);
	}
	$action=strtolower($matches[1]);

	switch ($action) {
		case 'feed':

			if(!isset($_REQUEST['action']))
			{

				if(!isset($_SESSION['userid']))
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

				if($matchPage=Uri::match('\/category\/(\d+)'))
				{
					$catid=$matchPage[1];
					$queryData['where']="where catid='$catid'";
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

				if(!$getData=Post::get($queryData))
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

					if(!isset($userData[0]['postid']))
					{
						return json_encode($resultData);
					}							

					$userid=$userData[0]['postid'];

					$groupid=$userData[0]['groupid'];

				}

				$userid=Session::get('userid');

				$groupid=Session::get('groupid');

				$userPermission=GlobalCMS::$usergroups;

				// print_r($userPermission);die();

				if((int)$userPermission['can_manage_post']==0)
				{
					return json_encode($resultData);
				}

				switch ($rqAction) {
					case 'insert':

					if((int)$userPermission['can_addnew_post']==0)
					{
						return json_encode($resultData);
					}

						$valid=Validator::make(array(
							'title'=>'max:255|slashes',
							'catid'=>'slashes',
							'image'=>'max:255|slashes',
							'keywords'=>'max:255|slashes',
							'pageid'=>'slashes',
							'is_featured'=>'max:1|number|slashes',
							'status'=>'max:1|number|slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						$postData=array(
							'title'=>Request::get('title'),
							'catid'=>Request::get('catid',0),
							'userid'=>$userData[0]['userid'],
							'content'=>Request::get('content',''),
							'keywords'=>Request::get('keywords',''),
							'image'=>$imgPath,
							'pageid'=>Request::get('pageid',0),
							'status'=>Request::get('status',0)
							);

						if(!$id=Post::insert($postData))
						{
							return json_encode($resultData);
						}

						$imgPath='';

						if(isset($_REQUEST['image']))
						{
							$imgUrl=trim($_REQUEST['image']);

							if(preg_match('/http:\/\/.*?\.(\w+)/i', $imgUrl,$matchImg))
							{
								$ext=$matchImg[1];

								$imgData=Http::getDataUrl($imgUrl);

								$imgPath='uploads/images/post_'.$id.'.'.$ext;

								File::create(ROOT_PATH.$imgPath,$imgData);

								Post::update($id,array('image'=>$imgPath));
							}
						}

						$resultData=array('postid'=>$id);

						return json_encode($resultData);
						break;

					case 'insertThumbnail':

					if((int)$userPermission['can_addnew_post']==0)
					{
						return json_encode($resultData);
					}					

						$valid=Validator::make(array(
							'postid'=>'slashes',
							'urlThumbnail'=>'slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						$postData=array(
							'urlThumbnail'=>Request::get('urlThumbnail')
							);

						if(!$id=Post::insertThumbnail(Request::get('postid'),$postData))
						{
							return json_encode($resultData);
						}

						return json_encode(array('ok'=>'OK'));
						break;

					case 'update':

						$valid=Validator::make(array(
							'postid'=>'number|slashes',
							'send.title'=>'max:255|slashes',
							'send.catid'=>'slashes',
							'send.keywords'=>'max:255|slashes',
							'send.pageid'=>'slashes',
							'send.is_featured'=>'max:1|number|slashes',
							'send.status'=>'max:1|number|slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						Post::update(Request::get('postid'),Request::get('send'));

						return json_encode(array('ok'=>'OK'));
						break;

					case 'delete':

						$valid=Validator::make(array(
							'postid'=>'slashes'
							));

						if(!$valid)
						{
							return json_encode($resultData);
						}

						$postid=Request::get('postid');

						$loadData=Post::get(array(
							'where'=>"where postid='$postid'"
							));

						if(!isset($loadData[0]['postid']))
						{
							return json_encode($resultData);
						}

						if($loadData[0]['userid']!=$userid)
						{
							if((int)$userPermission['can_delete_post']==0)
							{
								return json_encode($resultData);	
							}					
						}
						else
						{
							if((int)$userPermission['can_deleteowner_post']==0)
							{
								return json_encode($resultData);	
							}									
						}
						Post::remove(array(Request::get('postid')));

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