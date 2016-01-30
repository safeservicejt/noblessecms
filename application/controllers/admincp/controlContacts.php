<?php

class controlContacts
{
	public function index()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_manage_contactus');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}    

		$post=array('alert'=>'');

		Model::load('admincp/contacts');

		if($match=Uri::match('\/contacts\/(\w+)'))
		{
			if(method_exists("controlContacts", $match[1]))
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
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_remove_contactus');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			} 
			  			
			actionProcess();
		}

		$post['theList']=Contactus::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'cacheTime'=>1
			));

		$countPost=Contactus::get(array(
			'selectFields'=>'count(contactid)as totalRow',
			'cache'=>'no'
			));

		$post['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/contacts',
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($post['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$post['totalPost']=$countPost[0]['totalRow'];

		$post['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		System::setTitle('Contacts list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('contactsList',$post);

		View::make('admincp/footer');

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
			'where'=>"where contactid='$postid'"
			));

		$post=$loadData[0];

		System::setTitle('View contact - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('contactView',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>