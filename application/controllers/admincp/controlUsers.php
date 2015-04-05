<?php

class controlUsers
{

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

		Model::load('misc');
		Model::load('admincp/users');

		if(Request::has('btnAction'))
		{
			actionProcess();

		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('users',$curPage);


		// $post['usergroups']=Usergroups::get();
		
		$post['users']=Users::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage

			));

		// $post['usergroups']=UserGroups::get();

		

		// print_r($post['usergroups']);die();

		// $post['allcustomers']=allCustomers();


		View::make('admincp/head',array('title'=>'List users - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/customersList',$post);

        $this->makeContents('userList',$post);
        
        View::make('admincp/footer'); 		
	}


	public function addnew()
	{

		$post=array('alert'=>'');

		Model::load('misc');


		if(Request::has('btnAdd'))
		{
				$post['alert']='<div class="alert alert-success">Add new user success.</div>';

				// editCustomer($post['id'],Request::get('send'));	

				$send=Request::get('send');

				$send['password']=md5($send['password']);

				if(!$userid=Users::insert($send))
				{
					$post['alert']='<div class="alert alert-warning">Add new user error.</div>';
				}
				else
				{
					$address=Request::get('address');

					$address['userid']=$userid;

					$address['firstname']=$send['firstname'];

					$address['lastname']=$send['lastname'];

					Address::insert($address);	
						
					$post=array(
						'userid'=>$userid,
						'commission'=>GlobalCMS::$setting['default_affiliate_commission']
						);

					Affiliate::insert($post);

				}

		}


		$post['usergroups']=UserGroups::get(array('orderby'=>'order by group_title asc'));		

		View::make('admincp/head',array('title'=>'Add new user - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/customerEdit',$post);

        $this->makeContents('userAdd',$post);

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

				// editCustomer($post['id'],Request::get('send'));	

				$data=Request::get('address');

				$updateData=array(
					'firstname'=>$data['firstname'],
					'lastname'=>$data['lastname'],
					'groupid'=>Request::get('send.groupid')
					);

				// $send['password']=md5($data['password']);	
							
				Users::update($id,$updateData);

				Address::update($id,$data);


		}


		// $data=Users::get(array('where'=>"where userid='$id'"));
		$data=Users::get(array(
			'query'=>"select u.groupid,u.date_added,a.firstname,a.lastname,a.address_1,a.address_2,a.city,a.state,a.country,a.postcode,a.phone,a.fax from users u,address a where u.userid=a.userid AND u.userid='$id'"
			));

		$post['edit']=$data[0];

		$post['usergroups']=UserGroups::get(array('orderby'=>'order by group_title asc'));		

		View::make('admincp/head',array('title'=>'Edit user - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/customerEdit',$post);

        $this->makeContents('userEdit',$post);

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