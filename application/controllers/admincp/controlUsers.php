<?php

class controlUsers
{
	public function index()
	{
		CustomPlugins::load('admincp_before_manage_user');

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_manage_user');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		

		
		$post=array('alert'=>'');

		Model::load('admincp/users');

		if($match=Uri::match('\/users\/(\w+)'))
		{
			if(method_exists("controlUsers", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

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
				$post['alert']='<div class="alert alert-success">Success. New password is: '.$result.'</div>';
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

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}			

		$post['theList']=Users::get(array(
			'cache'=>'no',
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'query'=>"select u.*,ug.*,a.* from ".$prefix."users u,".$prefix."usergroups ug,address a where ".$addWhere." u.groupid=ug.groupid AND u.userid=a.userid group by u.userid order by u.userid desc",
			'cacheTime'=>1
			));


		$countPost=Post::get(array(
			'query'=>"select count(u.userid)as totalRow from ".$prefix."users u,".$prefix."usergroups ug,address a where ".$addWhere." u.groupid=ug.groupid AND u.userid=a.userid group by u.userid order by u.userid desc",
			'cache'=>'no'
			));

		$post['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/users'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($post['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$post['totalPost']=$countPost[0]['totalRow'];

		$post['totalPage']=intval((int)$countPost[0]['totalRow']/20);


		System::setTitle('User list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('userList',$post);

		View::make('admincp/footer');

	}


	public function addnew()
	{
		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new user success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}


		$post['listGroups']=UserGroups::get(array(
			'orderby'=>'order by group_title asc'
			));
			
		System::setTitle('Add new User - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('userAdd',$post);

		View::make('admincp/footer');		
	}
	public function edit()
	{
		$post=array('alert'=>'');
				
		$match=Uri::match('\/edit\/(\d+)');

		$userid=$match[1];

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($userid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnChangePassword'))
		{
			Users::changePassword($userid,Request::get('thepass',''));

			$post['alert']='<div class="alert alert-success">Save change password success.</div>';
		}

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}	

		$loadData=Users::get(array(
				'query'=>"select u.*,ug.*,a.* from ".$prefix."users u,".$prefix."usergroups ug,".$prefix."address a where u.groupid=ug.groupid AND u.userid=a.userid AND u.userid='$userid' order by u.userid desc",
				'cache'=>'no'

			));

		$post['edit']=$loadData[0];

		$post['listGroups']=UserGroups::get(array(
			'cache'=>'no',
			'orderby'=>'order by group_title asc'
			));
			
		System::setTitle('Edit User - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('userEdit',$post);

		View::make('admincp/footer');		
	}

	public function profile()
	{
		$post=array('alert'=>'');
				
		$match=Uri::match('\/profile$');

		$userid=Users::getCookieUserId();

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_change_profile');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}
						
			try {
				
				updateProcess($userid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnChangePassword'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_change_password');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}		
				
			Users::changePassword($userid,Request::get('password',''));
		}

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		$loadData=Users::get(array(
				'query'=>"select u.*,ug.*,a.* from ".$prefix."users u,".$prefix."usergroups ug,".$prefix."address a where u.groupid=ug.groupid AND u.userid=a.userid AND u.userid='$userid' order by u.userid desc",

			));

		$post['edit']=$loadData[0];

		$post['listGroups']=UserGroups::get();
		
		System::setTitle('Profile - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('userEdit',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}
