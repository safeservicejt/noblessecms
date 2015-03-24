<?php

class controlUserGroups
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

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				UserGroups::remove(Request::get('id'));
			}

		}


		$curPage=Uri::getNext('usergroups');

		if($curPage=='page')
		{
			$curPage=Uri::getNext('page');
		}
		else
		{
			$curPage=0;
		}



		$post['pages']=genPage('usergroups',$curPage);

		$post['usergroups']=UserGroups::get(array(

			'limitPage'=>$curPage,
			'limitShow'=>20,
			'orderby'=>'order by group_title asc'			
			
			));

		// print_r($post['categories']);die();

		View::make('admincp/head',array('title'=>'List user groups - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/newsList',$post);

        $this->makeContents('usergroupsList',$post);        

        View::make('admincp/footer'); 		
	}


	public function addnew()
	{

		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/news');
		// Model::load('admincp/categories');
		// Model::load('admincp/pages');

		$post['id']=Uri::getNext('edit');

		if(Request::has('btnAdd'))
		{
				$post['alert']='<div class="alert alert-success">Add new user group success.</div>';

				$data=Request::get('groupdata');

				$title=Request::get('title');

				$data['group_title']=$title;

				if(!isset($title[1]))
				{
					$post['alert']='<div class="alert alert-warning">Add new user group error.</div>';
				}
				else
				{
					$data['groupdata']=Request::get('groupdata');

					UserGroups::add($data);					
				}
		}

		// print_r($post['categories']);die();

		View::make('admincp/head',array('title'=>'Add new user group - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/newsAdd',$post);

        $this->makeContents('usergroupsAdd',$post);        

        View::make('admincp/footer'); 			
	}	

	public function edit()
	{

		$post=array('alert'=>'');

		Model::load('misc');

		$id=Uri::getNext('edit');

		$post['id']=$id;

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

				$data=array();

				$title=Request::get('title');

				$data['group_title']=$title;

				// print_r($data);die();

				$data['groupdata']=json_encode(Request::get('groupdata'));

				UserGroups::update($id,$data);				
		}

		$postData=UserGroups::get(array('where'=>"where groupid='$id'"));

		

		$post['title']=$postData[0]['group_title'];

		$post['data']=json_decode($postData[0]['groupdata'],true);

		// print_r($post['data']);die();

		View::make('admincp/head',array('title'=>'Edit user group - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/newsEdit',$post);

        $this->makeContents('usergroupsEdit',$post);       

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