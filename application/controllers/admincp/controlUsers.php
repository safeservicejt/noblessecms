<?php

class controlUsers
{
	public function index()
	{
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
			actionProcess();
		}

		if(Request::has('btnSearch'))
		{
			filterProcess();
		}
		else
		{
			$post['pages']=Misc::genSmallPage('admincp/users',$curPage);

			$post['theList']=Users::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'query'=>"select u.*,ug.*,a.* from users u,usergroups ug,address a where u.groupid=ug.groupid AND u.userid=a.userid order by u.userid desc",
				'cacheTime'=>15
				));
		}

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



		$loadData=Users::get(array(
				'query'=>"select u.*,ug.*,a.* from users u,usergroups ug,address a where u.groupid=ug.groupid AND u.userid=a.userid AND u.userid='$userid' order by u.userid desc",

			));

		$post['edit']=$loadData[0];

		$post['listGroups']=UserGroups::get(array(
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

		$userid=$_SESSION['userid'];

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
			Users::changePassword($userid,Request::get('password',''));
		}



		$loadData=Users::get(array(
				'query'=>"select u.*,ug.*,a.* from users u,usergroups ug,address a where u.groupid=ug.groupid AND u.userid=a.userid AND u.userid='$userid' order by u.userid desc",

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

?>