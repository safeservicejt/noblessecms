<?php

class controlPages
{

	public function index()
	{
		if(Uri::has('edit'))
		{
			$this->edit();
			die();
		}

		if(Uri::has('addnew'))
		{
			$this->addnew();
			die();
		}


		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/pages');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(Request::has('id'))
				Pages::remove(Request::get('id'));	
			}
			if(Request::get('action')=='publish')
			{
				if(Request::has('id'))
				{
					Pages::update(Request::get('id'),array(
						'status'=>1
						));
				}					
			}
			if(Request::get('action')=='unpublish')
			{
				if(Request::has('id'))
				{
					Pages::update(Request::get('id'),array(
						'status'=>0
						));
				}			
			}
		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=Misc::genPage('admincp/pages',$curPage);

		if(!Request::has('btnSearch'))
		{
			$post['listPages']=Pages::get(array(
				'limitPage'=>$curPage,
				'limitShow'=>20,
				'isHook'=>'no'			
				));		
		}
		else
		{	
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['listPages']=$searchData['listPages'];

			$post['pages']=$searchData['pages'];

		}		




		View::make('admincp/head',array('title'=>'List pages - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesList',$post);

        $this->makeContents('pagesList',$post);        

        View::make('admincp/footer'); 		
	}


	public function addnew()
	{

		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/pages');

		if(Request::has('btnAdd'))
		{
				$post['alert']='<div class="alert alert-success">Add new page success.</div>';

				// addPage(Request::get('send'));	

				$inputData=Request::get('send');

				$inputData['friendly_url']=Url::makeFriendly($inputData['title']);

				Pages::add($inputData);
		}


		View::make('admincp/head',array('title'=>'Add new page - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesAdd',$post);

        $this->makeContents('pagesAdd',$post);        

        View::make('admincp/footer'); 			
	}	

	public function edit()
	{

		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/pages');

		$id=Uri::getNext('edit');
		$post['id']=$id;

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

				Pages::update($id,Request::get('send'));
		}

		$loadData=Pages::get(array('where'=>"where pageid='$id'"));
		$post['edit']=$loadData[0];	


		View::make('admincp/head',array('title'=>'Edit page'.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesEdit',$post);

        $this->makeContents('pagesEdit',$post);       

        View::make('admincp/footer'); 			
	}
    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/nav');
                
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');
         // View::make('admincp/right');

    }

}

?>