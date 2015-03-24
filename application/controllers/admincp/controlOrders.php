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
		if(Uri::has('approve'))
		{
			$this->approve();
			die();
		}

		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/orders');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Orders::remove(Request::get('id'));		
			}

		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('orders',$curPage);
		
		$post['theList']=Orders::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage
			));

		View::make('admincp/head',array('title'=>'List orders - '.ADMINCP_TITLE));

        $this->makeContents('ordersList',$post);
        
        View::make('admincp/footer'); 		
	}

	public function view()
	{
		if(!$match=Uri::match('orders\/view\/(\d+)'))
		{
			Alert::make('Order not found');
		}

		$id=$match[1];

		$orderData=Orders::get(array(
			'where'=>"where nodeid='$id'"
			));

		if(!isset($orderData[0]['nodeid']))
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

		// print_r($post['products']);die();


		View::make('admincp/head',array('title'=>'Order information - '.ADMINCP_TITLE));

        $this->makeContents('ordersView',$post);
        
        View::make('admincp/footer'); 			

	}

	public function approve()
	{
		if($match=Uri::match('orders\/approve\/(\d+)'))
		{
			Model::load('admincp/orders');

			$id=$match[1];

			approveProcess($id);

			Redirect::to(ADMINCP_URL.'orders');
		}
		else
		{
			Redirect::to(ADMINCP_URL.'orders');
		}
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