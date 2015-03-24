<?php

class controlAffiliates
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}
	public function index()
	{
		if(Uri::has('addnew'))
		{
			$this->addnew();
			die();
		}
		if(Uri::has('edit'))
		{
			$this->edit();
			die();
		}


		$post=array('alert'=>'');

		// Model::load('misc');
		Model::load('usercp/users');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				removeUser(Request::get('id'));		
			}
			if(Request::get('action')=='approved')
			{
				publishUser(Request::get('id'));		
			}
			if(Request::get('action')=='unapproved')
			{
				unpublishUser(Request::get('id'));		
			}
			
			if(Request::get('action')=='isadmin')
			{
				setAdmin(Request::get('id'));		
			}
			if(Request::get('action')=='notadmin')
			{
				setUser(Request::get('id'));		
			}

		}		

		$curPage=Uri::getNext('affiliates');

		if($curPage=='page')
		{
			$curPage=Uri::getNext('page');
		}
		else
		{
			$curPage=0;
		}

		$post['pages']=genPage('affiliates',$curPage);


		// $post['usergroups']=Usergroups::get();


		
		$post['users']=Affiliate::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'query'=>"select a.earned,a.commission,a.userid,u.firstname,u.lastname from affiliate a,users u where a.userid=u.userid order by a.userid desc"
			));

		// $post['usergroups']=UserGroups::get();

		

		// print_r($post['usergroups']);die();

		// $post['allcustomers']=allCustomers();


		View::make('usercp/head',array('title'=>'List affiliate - '.ADMINCP_TITLE));

        $this->makeContents('affiliatesList',$post);
        
        View::make('usercp/footer'); 		
	}


	public function addnew()
	{

		$post=array('alert'=>'');

		Model::load('misc');


		if(Request::has('btnAdd'))
		{
				$post['alert']='<div class="alert alert-success">Add new user success.</div>';

				// editCustomer($post['id'],Request::get('send'));	

				$data=Request::get('send');
				Users::insert($data);
		}


		$post['usergroups']=UserGroups::get(array('orderby'=>'order by group_title asc'));		

		View::make('usercp/head',array('title'=>'Add new user'.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/customerEdit',$post);

        $this->makeContents('userAdd',$post);

        View::make('usercp/footer'); 			
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

				// editCustomer($post['id'],Request::get('send'));	

				$data=Request::get('send');
				Users::update($id,$data);
		}


		$data=Users::get(array('where'=>"where userid='$id'"));
		$post['edit']=$data[0];

		$post['usergroups']=UserGroups::get(array('orderby'=>'order by group_title asc'));		

		View::make('usercp/head',array('title'=>'Edit user'.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/customerEdit',$post);

        $this->makeContents('userEdit',$post);

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