<?php

class controlRedirects
{
	public function index()
	{
		CustomPlugins::load('admincp_before_manage_redirect');

		$post=array('alert'=>'');

		Model::load('admincp/redirects');
		
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

				$post['alert']='<div class="alert alert-success">Add new category success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
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

				$post['alert']='<div class="alert alert-success">Update redirect success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSearch'))
		{
			filterProcess();
		}
		else
		{
			$post['pages']=Misc::genSmallPage('admincp/redirects',$curPage);

			$post['theList']=Redirect::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>'order by id desc',
				'cache'=>'no'
				));
		}

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Redirect::get(array(
				'where'=>"where id='".$match[1]."'",
				'cache'=>'no'
				));

			$post['edit']=$loadData[0];
		}

		System::setTitle('Redirects list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('redirectsList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>