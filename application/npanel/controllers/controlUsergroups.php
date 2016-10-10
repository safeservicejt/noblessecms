<?php

class controlUsergroups
{
	public static function index()
	{

		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_manage_usergroup');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		

		$pageData=array('alert'=>'');

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{
			actionProcess();
		}

		// $valid=Usergroups::getThisPermission('can_addnew_usergroup');


		$pageData['theList']=Usergroups::get(array(
			'cache'=>'no',
			'cacheTime'=>1,
			'limitShow'=>20,
			'limitPage'=>$curPage
			));

		$countPost=Usergroups::get(array(
			'selectFields'=>'count(id)as totalRow',
			'cache'=>'no'
			));


		$countPost[0]['totalRow']=isset($countPost[0]['totalRow'])?$countPost[0]['totalRow']:0;

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/usergroups/',
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		
		System::setTitle('Usergroups list - nPanel');		

		Views::make('head');

		Views::make('left');

		Views::make('usergroupsList',$pageData);

		Views::make('footer');		
	}	

	public static function addnew()
	{
		$pageData=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new user group success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		System::setTitle('Add new usergroup - nPanel');
		
		Views::make('head');

		Views::make('left');

		Views::make('usergroupsAdd',$pageData);

		Views::make('footer');					
	}

	public static function edit()
	{
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirects::to(System::getAdminUrl().'usergroups/');
		}


		$groupid=$match[1];

		$pageData=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($groupid);

				$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=Usergroups::get(array(
			'cache'=>'no',
			'where'=>"where id='$groupid'"
			));

		$pageData['edit']=$loadData[0];

		System::setTitle('Edit group - nPanel');	
		
		Views::make('head');

		Views::make('left');

		Views::make('usergroupsEdit',$pageData);

		Views::make('footer');					
	}


}