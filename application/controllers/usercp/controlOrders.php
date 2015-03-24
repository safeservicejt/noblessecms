<?php

class controlOrders
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}
	public function index()
	{
		if(Uri::has('view'))
		{
			$this->view();
			die();
		}

		$post=array('alert'=>'');

		Model::load('usercp/misc');
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

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}


		$userid=Session::get('userid');

		$post['pages']=genPage('orders',$curPage);

		DBCache::disable();

		$post['theList']=Orders::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'where'=>"where customerid='$userid'"
			));
		
		DBCache::enable();
		View::make('usercp/head',array('title'=>'List orders - '.ADMINCP_TITLE));

        $this->makeContents('ordersList',$post);
        
        View::make('usercp/footer'); 		
	}

	public function view()
	{
		if(!$match=Uri::match('orders\/view\/(\d+)'))
		{
			Alert::make('Order not found');
		}

		Model::load('usercp/orders');

		$id=$match[1];

		$userid=Session::get('userid');

		$orderData=Orders::get(array(
			'where'=>"where orderid='$id' AND customerid='$userid'"
			));

		if(!isset($orderData[0]['orderid']))
		{
			Alert::make('Order not found');
		}

		$products=Orders::products($id);

				// print_r($orderData);die();

		if(!$products)
		{
			Alert::make('Order is empty!');
		}

		$post=array();

		$post['products']=$products;

		$post['orders']=$orderData[0];	

		$post=orderDetails($post);
		// print_r($post['products']);die();

		View::make('usercp/head',array('title'=>'Order information - '.ADMINCP_TITLE));

        $this->makeContents('ordersView',$post);
        
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