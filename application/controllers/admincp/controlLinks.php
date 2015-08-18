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
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new link success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$post['alert']='<div class="alert alert-success">Update link success.</div>';

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
			$post['pages']=Misc::genSmallPage('admincp/links',$curPage);

			$post['theList']=Links::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>'order by sort_order asc',
				'cache'=>'no'
				));
		}

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