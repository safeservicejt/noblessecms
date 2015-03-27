<?php

class controlUsers
{

	public function index()
	{
		if(Uri::has('profile'))
		{
			$this->edit();
			die();
		}
		if(Uri::has('password'))
		{
			$this->password();
			die();
		}
		if(Uri::has('paymentinfo'))
		{
			$this->paymentinfo();
			die();
		}
		if(Uri::has('affiliate'))
		{
			$this->affiliate();
			die();
		}
		if(Uri::has('rqpayment'))
		{
			$this->rqpayment();
			die();
		}
		if(Uri::has('paymenthistory'))
		{
			$this->paymenthistory();
			die();
		}

	}


	public function password()
	{

		$post=array('alert'=>'');

		Model::load('misc');

		$id=Session::get('userid');

		$post['id']=$id;

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Change your password success.</div>';

				$data=Request::get('send');

				$valid=Validator::check(array(

				$data['password']=>'min:5|slashes',
				$data['repassword']=>'min:5|slashes'

				));

				if($valid)
				{
					if($data['password']!=$data['repassword'])
					{
						$post['alert']='<div class="alert alert-warning">Change your password error.</div>';
					}
					else
					{
						$send=array('password'=>md5($data['password']));

						Cookie::make('password',md5($data['password']),8640);

						Users::update($id,$data);	
					}
				}
				else
				{
					$post['alert']='<div class="alert alert-warning">Change your password error.</div>';
				}				

		}


		View::make('usercp/head',array('title'=>'Change your password - '.ADMINCP_TITLE));

        $this->makeContents('userPassword',$post);

        View::make('usercp/footer'); 			
	}


	public function edit()
	{

		$post=array('alert'=>'');

		Model::load('misc');

		$id=Session::get('userid');

		$post['id']=$id;

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

				$data=Request::get('send');

				$address=Request::get('address');

				Users::update($id,$data);


				Address::update($id,$address);

		}

		DBCache::disable();

		$data=Users::get(array('where'=>"where userid='$id'"));

		$address=Address::get(array('where'=>"where userid='$id'"));

		DBCache::enable();

		$post['edit']=$data[0];
		$post['address']=$address[0];	

		View::make('usercp/head',array('title'=>'Edit user - '.ADMINCP_TITLE));

        $this->makeContents('userEdit',$post);

        View::make('usercp/footer'); 			
	}
	public function paymentinfo()
	{

		$post=array('alert'=>'');

		Model::load('misc');

		$id=Session::get('userid');

		$post['id']=$id;

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

				$data=Request::get('send');

				Affiliate::update($id,$data);
		}

		DBCache::disable();		
		$data=Affiliate::get(array('where'=>"where userid='$id'"));
		DBCache::enable();		

		if($data==false)
		{
			Affiliate::insert(array('userid'=>$id));

			$post['edit']=array();			
		}
		else
		{
			$post['edit']=$data[0];			
		}

		View::make('usercp/head',array('title'=>'Payment information - '.ADMINCP_TITLE));

        $this->makeContents('userPayment',$post);

        View::make('usercp/footer'); 			
	}
	public function affiliate()
	{

		$post=array('alert'=>'');

		Model::load('misc');

		$id=Session::get('userid');

		$post['id']=$id;

		$loadData=Affiliate::get(array('where'=>"where userid='$id'"));

		$post['edit']=$loadData[0];
		
		// print_r($post);die();

		View::make('usercp/head',array('title'=>'Affiliate information - '.ADMINCP_TITLE));

        $this->makeContents('userAffiliate',$post);

        View::make('usercp/footer'); 			
	}
	public function rqpayment()
	{

		$post=array('alert'=>'');

		Model::load('usercp/users');

		$id=Session::get('userid');

		$post['id']=$id;

		if(Request::has('btnSend'))
		{
			$post['alert']='<div class="alert alert-warning">Error. Have error while send your request payment. Check your request information again, pls!</div>';

			if(requestPaymentProcess($id))
			{
				$post['alert']='<div class="alert alert-success">Send request success. We will check your request soon!</div>';
			}
		}

		DBCache::disable();

		$loadData=Affiliate::get(array('where'=>"where userid='$id'"));

		DBCache::enable();

		$post['edit']=$loadData[0];

		if((double)$post['edit']['earned']==0)
		{
			Redirect::to(USERCP_URL);
		}

		// print_r($post);die();

		View::make('usercp/head',array('title'=>'Affiliate information - '.ADMINCP_TITLE));

        $this->makeContents('userRequestPayment',$post);

        View::make('usercp/footer'); 			
	}
	public function paymenthistory()
	{
		Model::load('usercp/misc');

		$post=array('alert'=>'');

		// Model::load('usercp/users');

		$id=Session::get('userid');

		$post['id']=$id;

		// print_r($post);die();
		$curPage=Uri::getNext('paymenthistory');

		if($curPage=='page')
		{
			$curPage=Uri::getNext('page');
		}
		else
		{
			$curPage=0;
		}

		$post['pages']=genPage('users/paymenthistory',$curPage);

		DBCache::disable();

		$post['theList']=Requestpayment::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,			
			'where'=>"where userid='$id'"
			));

		// print_r($post['theList']);die();

		DBCache::enable();		

		View::make('usercp/head',array('title'=>'Request payment history - '.ADMINCP_TITLE));

        $this->makeContents('rqPaymentHistory',$post);

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