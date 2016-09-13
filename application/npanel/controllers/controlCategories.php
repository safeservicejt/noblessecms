<?php

class controlCategories
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
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_remove_category');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}	

			actionProcess();
		}

		if(Request::has('btnAdd'))
		{

			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_category');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}			

			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new category success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_category');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$pageData['alert']='<div class="alert alert-success">Update category success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$addWhere='';

		$addPage='';

		if(Request::has('btnSearch'))
		{
			$txtKeywords=trim(Request::get('txtKeywords',''));

			$addWhere="where title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}

		if($matchS=Uri::match('\/search\/([a-zA-Z0-9_\-\=\+]+)'))
		{
			$txtKeywords=base64_decode($matchS[1]);

			$addWhere="where title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}

		$pageData['theList']=Categories::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'where'=>$addWhere,
			'orderby'=>'order by id desc',
			'cache'=>'no'
			));

		$pageData['listCat']=Categories::getRecursive(array(
			'orderby'=>'order by title asc',
			'cache'=>'no'
			));

		$pageData['theList']=Categories::getRecursiveFromInput($pageData['theList']);

		$countPost=Categories::get(array(
			'where'=>$addWhere,
			'selectFields'=>'count(id) as totalRow',
			'cache'=>'no'
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/categories/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Categories::get(array(
				'where'=>"where id='".$match[1]."'",
				'cache'=>'no'
				));

			$pageData['edit']=$loadData[0];
		}


		System::setTitle('Categories list - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('categoriesList',$pageData);

		Views::make('footer');		
	}	

	public static function edit()
	{
		self::index();
	}
}