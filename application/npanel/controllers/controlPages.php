<?php

class controlPages
{
	public static function index()
	{

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

		$pageData['theList']=Pages::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'where'=>$addWhere,
			'cacheTime'=>1
			));

		$countPost=Pages::get(array(
			'where'=>$addWhere,
			'selectFields'=>'count(id)as totalRow',
			'cacheTime'=>1
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/pages/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>30,
			'limitPage'=>5,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/30);

		System::setTitle('Pages list - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('pagesList',$pageData);

		Views::make('footer');		
	}	


	public static function edit()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_page');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}	
			
		
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirect::to(System::getAdminUrl().'pages/');
		}


		$id=$match[1];

		$pageData=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			try {
				
				updateProcess($id);

				$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=Pages::get(array(
			'where'=>"where id='$id'",
			'isHook'=>'no',
			'cache'=>'no'
			));

		$pageData['edit']=$loadData[0];

		System::setTitle('Edit page - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('pagesEdit',$pageData);

		Views::make('footer');		
	}
	public static function addnew()
	{

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_page');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}


		$pageData=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new page success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}
		
		System::setTitle('Add new page - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('pagesAdd',$pageData);

		Views::make('footer');		
	}

}