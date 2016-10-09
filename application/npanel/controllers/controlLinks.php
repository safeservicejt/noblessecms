<?php

class controlLinks
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

		if(Request::has('btnAdd'))
		{
			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_addnew_link');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}	

			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new link success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_edit_link');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$pageData['alert']='<div class="alert alert-success">Update link success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
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

			$addWhere="where title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}


		$pageData['theList']=Links::get(array(
			'limitShow'=>100,
			'limitPage'=>$curPage,
			'where'=>$addWhere,
			'orderby'=>'order by sort_order asc',
			'cache'=>'no'
			));

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Links::get(array(
				'where'=>"where id='".$match[1]."'",
				'cache'=>'no'
				));

			$pageData['edit']=$loadData[0];
		}

		$total=count($pageData['theList']);

		if((int)$total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$parentid=$pageData['theList'][$i]['parentid'];

				if((int)$parentid > 0)
				{
					$catData=Links::get(array(
						'cache'=>'no',
						'where'=>"where id='$parentid'"
						));

					if(isset($catData[0]['title']))
					{
						$pageData['theList'][$i]['title']=$catData[0]['title'].' -> '.$pageData['theList'][$i]['title'];
					}
				}
			}
		}		

		$pageData['listLinks']=Links::get(array(
			'orderby'=>'order by sort_order asc',
			'cache'=>'no'
			));

		$countPost=Links::get(array(
			'orderby'=>'order by sort_order asc',
			'selectFields'=>'count(id)as totalRow',
			'cache'=>'no'
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/links/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>100,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/100);
		

		System::setTitle('Links list - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('linksList',$pageData);

		Views::make('footer');		
	}	

	public static function edit()
	{
		self::index();
	}


}