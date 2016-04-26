<?php

class controlPages
{
	public function index()
	{
		CustomPlugins::load('admincp_before_manage_pages');

		$post=array('alert'=>'');

		Model::load('admincp/pages');

		if($match=Uri::match('\/pages\/(\w+)'))
		{
			if(method_exists("controlPages", $match[1]))
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

		$addWhere='';
		$addPage='';
		
		if($matchS=Uri::match('\/search\/([a-zA-Z0-9_\-\=\.\+]+)'))
		{

			$txtKeywords=base64_decode($matchS[1]);

			$addWhere="where title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);			
		}

		if(Request::has('btnSearch'))
		{
			$txtKeywords=trim(Request::get('txtKeywords',''));

			$addWhere="where title LIKE '%$addWhere%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}

		$post['theList']=Pages::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'where'=>$addWhere,
			'cacheTime'=>1
			));

		$countPost=Pages::get(array(
			'where'=>$addWhere,
			'selectFields'=>'count(pageid)as totalRow',
			'cacheTime'=>1
			));

		$post['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/pages/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($post['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$post['totalPost']=$countPost[0]['totalRow'];

		$post['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		System::setTitle('Pages list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pagesList',$post);

		View::make('admincp/footer');

	}

	public function edit()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_page');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}	
			
		$username=$_COOKIE['username'].'/page';

		System::makeFileManagePath($username);
		
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirect::to(System::getAdminUrl().'pages/');
		}


		$pageid=$match[1];

		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			try {
				
				updateProcess($pageid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=Pages::get(array(
			'where'=>"where pageid='$pageid'",
			'isHook'=>'no',
			'cache'=>'no'
			));

		$post['edit']=$loadData[0];

		System::setTitle('Edit page - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pagesEdit',$post);

		View::make('admincp/footer');		
	}
	public function addnew()
	{

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_page');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$username=$_COOKIE['username'].'/page';

		System::makeFileManagePath($username);

		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new page success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}
		
		System::setTitle('Add new page - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pagesAdd',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}
