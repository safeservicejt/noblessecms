<?php

class controlRedirects
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
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_remove_redirect');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			actionProcess();
		}

		if(Request::has('btnAdd'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_redirect');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}	

			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new redirect success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_redirect');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$pageData['alert']='<div class="alert alert-success">Update redirect success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$addWhere='';

		$addPage='';

		if($matchS=Uri::match('\/search\/([a-zA-Z0-9_\-\=\.\+]+)'))
		{

			$txtKeywords=base64_decode($matchS[1]);

			$addWhere="where from_url LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);			
		}

		if(Request::has('btnSearch'))
		{
			$txtKeywords=trim(Request::get('txtKeywords',''));

			$addWhere="where from_url LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}


		$pageData['theList']=Redirects::get(array(
			'limitShow'=>100,
			'limitPage'=>$curPage,
			'where'=>$addWhere,
			'orderby'=>'order by id asc',
			'cache'=>'no'
			));

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Redirects::get(array(
				'where'=>"where id='".$match[1]."'",
				'cache'=>'no'
				));

			if(!isset($loadData[0]['id']))
			{
				Redirects::to(System::getUrl().'npanel/redirects');
			}

			$pageData['edit']=$loadData[0];
		}


		$countPost=Redirects::get(array(
			'orderby'=>'order by id asc',
			'selectFields'=>'count(id)as totalRow',
			'cache'=>'no'
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/redirects/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>100,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/100);
		


		System::setTitle('Redirects list - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('redirectsList',$pageData);

		Views::make('footer');		
	}	

	public static function edit()
	{
		self::index();
	}


}