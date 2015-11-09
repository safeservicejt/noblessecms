<?php

class controlLinks
{
	public function index()
	{
		
		$post=array('alert'=>'');

		Model::load('admincp/links');
		
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
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_link');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}	

			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new link success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_link');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$post['alert']='<div class="alert alert-success">Update link success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
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


		$post['pages']=Misc::genSmallPage('admincp/links'.$addPage,$curPage);

		$post['theList']=Links::get(array(
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

			$post['edit']=$loadData[0];
		}

		$post['listLinks']=Links::get(array(
			'orderby'=>'order by sort_order asc',
			'cache'=>'no'
			));

		System::setTitle('Links list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('linksList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>