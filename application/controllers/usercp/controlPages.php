<?php

class controlPages
{
	function __construct()
	{
		if(UserGroups::enable('can_manage_page')==false){
			Alert::make('Page not found');
		}
	}

	public function index()
	{
		if(Uri::has('edit'))
		{
			if(UserGroups::enable('can_edit_page')==false){
				Alert::make('Page not found');
			}		
					
			$this->edit();
			die();
		}

		if(Uri::has('addnew'))
		{
			if(UserGroups::enable('can_addnew_page')==false){
				Alert::make('Page not found');
			}			

			$this->addnew();
			die();
		}


		$post=array('alert'=>'');

		Model::load('usercp/misc');
		Model::load('usercp/pages');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(UserGroups::enable('can_delete_page')==false){
					Alert::make('Page not found');
				}			
						
				Pages::remove(Request::get('id'));	
			}
		}		

		$curPage=Uri::getNext('pages');

		if($curPage=='page')
		{
			$curPage=Uri::getNext('page');
		}
		else
		{
			$curPage=0;
		}

		$post['pages']=genPage('pages',$curPage);

		$post['listPages']=Pages::get(array(
			'limitPage'=>$curPage,
			'limitShow'=>20,
			'isHook'=>'no'			
			));


		View::make('usercp/head',array('title'=>'List pages - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesList',$post);

        $this->makeContents('pagesList',$post);        

        View::make('usercp/footer'); 		
	}


	public function addnew()
	{

		$post=array('alert'=>'');

		// Model::load('misc');
		// Model::load('admincp/pages');

		if(Request::has('btnAdd'))
		{
				$post['alert']='<div class="alert alert-success">Add new page success.</div>';

				// addPage(Request::get('send'));	

				$inputData=Request::get('send');

				$inputData['friendly_url']=Url::makeFriendly($inputData['title']);

				Pages::add($inputData);
		}


		View::make('usercp/head',array('title'=>'Add new page - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesAdd',$post);

        $this->makeContents('pagesAdd',$post);        

        View::make('usercp/footer'); 			
	}	

	public function edit()
	{

		$post=array('alert'=>'');

		// Model::load('misc');
		// Model::load('admincp/pages');

		$id=Uri::getNext('edit');
		$post['id']=$id;

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

				Pages::update($id,Request::get('send'));
		}
		DBCache::disable();
		
		$loadData=Pages::get(array('where'=>"where pageid='$id'"));
		$post['edit']=$loadData[0];	

		DBCache::enable();

		View::make('usercp/head',array('title'=>'Edit page'.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesEdit',$post);

        $this->makeContents('pagesEdit',$post);       

        View::make('usercp/footer'); 			
	}
    public function makeContents($viewPath,$inputData=array())
    {
        View::make('usercp/nav');
                
        View::make('usercp/left');  
              
        View::make('usercp/startContent');

        View::make('usercp/'.$viewPath,$inputData);

        View::make('usercp/endContent');
         // View::make('admincp/right');

    }

}

?>