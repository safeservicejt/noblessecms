<?php

class controlPost
{
	public static function index()
	{

		$pageData=array('alert'=>'');
		
		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$addWhere='';

		$addPage='';

		if(Request::has('btnAction'))
		{
			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_remove_post');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}			
			actionProcess();
		}

		if($matchSearch=Uri::match('\/search\/([a-zA-Z0-9_\+\=]+)'))
		{
			$txtKeywords=base64_decode($matchSearch[1]);

			$addWhere="where p.title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);			
		}

		if($matchSearch=Uri::match('\/category\/(\d+)'))
		{
			$txtKeywords=$matchSearch[1];

			$addWhere="where p.catid='$txtKeywords'";

			$addPage='/category/'.$txtKeywords;			
		}
		
		if($matchSearch=Uri::match('\/status\/pending'))
		{
			$addWhere.=" AND p.status='pending'";

			$addPage='/status/pending/';			
		}

		if(Request::has('btnSearch'))
		{
			$txtKeywords=trim(Request::get('txtKeywords',''));

			$addWhere="where p.title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}

		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_all_post');

		if($valid!='yes')
		{
			$userid=Users::getCookieUserId();
			
			$addWhere.=" AND  p.userid='$userid'";
		}



		$filterPending='';

		if(Uri::has('\/status\/pending'))
		{
			$filterPending=" WHERE p.status='0' ";
		}

		$pageData['theList']=Post::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'query'=>"select p.*,u.username,c.title as cattitle from post p left join users u on p.userid=u.id join categories c on p.catid=c.id $addWhere order by p.id desc",
			'cache'=>'no'
			));

		$countPost=Post::get(array(
			'query'=>"select count(p.id)as totalRow from post p left join users u on p.userid=u.id join categories c on p.catid=c.id $addWhere order by p.id desc",
			'cache'=>'no'
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/post/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		System::setTitle('Post list - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('postList',$pageData);

		Views::make('footer');		
	}	

	public static function status()
	{
		self::index();
	}

	public static function edit()
	{
		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_edit_post');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirects::to(System::getAdminUrl().'post/');
		}


		$postid=$match[1];

		$pageData=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($postid);

				$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=Post::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'query'=>"select p.*,c.title as cattitle from post p,categories c where p.catid=c.id AND p.id='$postid'"
			));

		$pageData['edit']=$loadData[0];

		// $pageData['tags']=PostTags::renderToText($postid);

		$postTags=isset($loadData[0]['tag_data'][5])?unserialize($loadData[0]['tag_data']):array();

		$totalTag=count($postTags);

		$li='';

		for ($i=0; $i < $totalTag; $i++) { 
			$li.=$postTags[$i]['title'].',';	
		}

		$pageData['tags']=$li;

		$pageData['listCat']=Categories::get(array(
			'orderby'=>'order by title asc',
			'cache'=>'no'
			));		

		$total=count($pageData['listCat']);

		if((int)$total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$parentid=$pageData['listCat'][$i]['parentid'];

				if((int)$parentid > 0)
				{
					$catData=Categories::get(array(
						'cache'=>'no',
						'where'=>"where id='$parentid'"
						));

					if(isset($catData[0]['title']))
					{
						$pageData['listCat'][$i]['title']=$catData[0]['title'].' -> '.$pageData['listCat'][$i]['title'];
					}
				}
			}
		}
		
		System::setTitle('Edit post - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('postEdit',$pageData);

		Views::make('footer');		
	}


	public static function addnew()
	{

		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_addnew_post');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$pageData=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new post success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$pageData['listCat']=Categories::get(array(
			'orderby'=>'order by title asc',
			'cache'=>'no'
			));		

		$total=count($pageData['listCat']);

		if((int)$total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$parentid=$pageData['listCat'][$i]['parentid'];

				if((int)$parentid > 0)
				{
					$catData=Categories::get(array(
						'cache'=>'no',
						'where'=>"where id='$parentid'"
						));

					if(isset($catData[0]['title']))
					{
						$pageData['listCat'][$i]['title']=$catData[0]['title'].' -> '.$pageData['listCat'][$i]['title'];
					}
				}
			}
		}

		System::setTitle('Add new post - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('postAdd',$pageData);

		Views::make('footer');		
	}

}