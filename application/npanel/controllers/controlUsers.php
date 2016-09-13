<?php

class controlUsers
{
	public static function index()
	{

		// $valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_manage_user');

		// if($valid!='yes')
		// {
		// 	Alert::make('You not have permission to view this page');
		// }		

		$pageData=array('alert'=>'');

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{
			$action=Request::get('action','');

			$result=actionProcess();

			if($action=='changepassword')
			{
				$pageData['alert']='<div class="alert alert-success">Success. New password is: '.$result.'</div>';
			}
		}

		$addWhere='';

		$addPage='';

		if(Request::has('btnSearch'))
		{
			$txtKeywords=trim(Request::get('txtKeywords',''));

			$addWhere="(u.username LIKE '%$txtKeywords%' OR u.email='$txtKeywords') AND ";

			$addPage='/search/'.base64_encode($txtKeywords);
		}

		if($matchSearch=Uri::match('\/search\/([a-zA-Z0-9_\+\=]+)'))
		{
			$txtKeywords=base64_decode($matchSearch[1]);

			$addWhere="(u.username LIKE '%$txtKeywords%' OR u.email='$txtKeywords') AND ";

			$addPage='/search/'.base64_encode($txtKeywords);			
		}

		$prefix='';

		$pageData['theList']=Users::get(array(
			'cache'=>'no',
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'query'=>"select u.*,ug.title as group_title,a.* from users u,usergroups ug,address a where ".$addWhere." u.groupid=ug.id AND u.id=a.userid group by u.id order by u.id desc",
			'cacheTime'=>1
			));


		$countPost=Users::get(array(
			'query'=>"select count(u.id)as totalRow from users u,usergroups ug,address a where ".$addWhere." u.groupid=ug.id AND u.id=a.userid group by u.id order by u.id desc",
			'cache'=>'no'
			));

		$countPost[0]['totalRow']=isset($countPost[0]['totalRow'])?$countPost[0]['totalRow']:0;

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/users/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);


		System::setTitle('Users List - nPanel');
	
		Views::make('head');

		Views::make('left');

		Views::make('usersList',$pageData);

		Views::make('footer');		
	}	

	public static function addnew()
	{
		$pageData=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new user success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}


		$pageData['listGroups']=UserGroups::get(array(
			'orderby'=>'order by title asc'
			));
			
		System::setTitle('Add new User - nPanel');
		
		Views::make('head');

		Views::make('left');

		Views::make('usersAdd',$pageData);

		Views::make('footer');					
	}

	public static function edit()
	{
		$pageData=array('alert'=>'');
				
		$match=Uri::match('\/edit\/(\d+)');

		$userid=$match[1];

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($userid);

				$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnChangePassword'))
		{
			Users::changePassword($userid,Request::get('thepass',''));

			$pageData['alert']='<div class="alert alert-success">Save change password success.</div>';
		}


		$loadData=Users::get(array(
				'query'=>"select u.*,ug.title as group_title,a.* from users u,usergroups ug,address a where u.groupid=ug.id AND u.id=a.userid AND u.id='$userid' order by u.id desc",
				'cache'=>'no'

			));


		$pageData['edit']=$loadData[0];

		$pageData['listGroups']=Usergroups::get(array(
			'cache'=>'no',
			'orderby'=>'order by title asc'
			));
			
		System::setTitle('Edit User - nPanel');	
		
		Views::make('head');

		Views::make('left');

		Views::make('usersEdit',$pageData);

		Views::make('footer');					
	}


}