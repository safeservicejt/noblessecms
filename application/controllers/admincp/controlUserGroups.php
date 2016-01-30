<?php

class controlUsergroups
{
	public function index()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_manage_usergroup');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		

		$post=array('alert'=>'');

		Model::load('admincp/usergroups');

		if($match=Uri::match('\/usergroups\/(\w+)'))
		{
			if(method_exists("controlUsergroups", $match[1]))
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

		// $valid=UserGroups::getThisPermission('can_addnew_usergroup');


		$post['theList']=UserGroups::get(array(
			'cache'=>'no',
			'cacheTime'=>1,
			'limitShow'=>20,
			'limitPage'=>$curPage
			));

		$countPost=UserGroups::get(array(
			'selectFields'=>'count(groupid)as totalRow',
			'cache'=>'no'
			));

		$post['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/usergroups',
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($post['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$post['totalPost']=$countPost[0]['totalRow'];

		$post['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		
		System::setTitle('Usergroups list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('usergroupsList',$post);

		View::make('admincp/footer');

	}

	public function edit()
	{
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirect::to(System::getAdminUrl().'usergroups/');
		}


		$groupid=$match[1];

		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($groupid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=UserGroups::get(array(
			'cache'=>'no',
			'where'=>"where groupid='$groupid'"
			));

		$post['edit']=$loadData[0];

		System::setTitle('Edit group - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('usergroupsEdit',$post);

		View::make('admincp/footer');		
	}
	public function addnew()
	{
		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new user group success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		System::setTitle('Add new usergroup - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('usergroupsAdd',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>