<?php

class controlContacts
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
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_remove_contactus');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			} 
			  			
			actionProcess();
		}

		$pageData['theList']=Contactus::get(array(
			'limitShow'=>50,
			'limitPage'=>$curPage,
			'cacheTime'=>1
			));

		$countPost=Contactus::get(array(
			'selectFields'=>'count(id)as totalRow',
			'cache'=>'no'
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/contacts/',
			'curPage'=>$curPage,
			'limitShow'=>50,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/50);

		System::setTitle('Contacts list - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('contactsList',$pageData);

		Views::make('footer');		
	}	


	public function view()
	{
		if(!$match=Uri::match('\/view\/(\d+)'))
		{
			Redirect::to(System::getAdminUrl().'contacts/');
		}


		$postid=$match[1];

		$post=array('alert'=>'');

		$loadData=Contactus::get(array(
			'where'=>"where id='$postid'"
			));

		$post=$loadData[0];

		System::setTitle('View contact - '.ADMINCP_TITLE);

		View::make('admincp/head');

		Views::make('left');

		Views::make('contactView',$post);

		View::make('admincp/footer');		
	}

}