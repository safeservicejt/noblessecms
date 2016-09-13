<?php

class controlOrder
{
	public function index()
	{
		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		if($owner=='yes')
		{
			$this->systemOrder();
		}
		else
		{
			$this->userOrder();
		}
	}

	public function view()
	{
		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		if($owner=='yes')
		{
			$this->systemView();
		}
		else
		{
			$this->userView();
		}
	}

	public function emailmarketing()
	{
		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		if($owner!='yes')
		{
			$refer=Http::get('refer');

			Redirect::to($refer);
		}


		$pageData=array('alert'=>'');


		if(Request::get('btnSend'))
		{
			$send=Request::get('send');

			Mail::send(array(
			'toEmail'=>$send['email'],
			'toName'=>$pageData['userData']['firstname'].' '.$pageData['userData']['lastname'],
			'subject'=>$send['subject'],
			'content'=>$send['content']		

			));

			$pageData['alert']='<div class="alert alert-success">Send email success.</div>';	
		}


		System::setTitle('Email Marketing');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('systemEmailMarketing',$pageData);

		CtrPlugin::admincpFooter();

	}

	public function sendemail()
	{
		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		if($owner!='yes')
		{
			$refer=Http::get('refer');

			Redirect::to($refer);
		}

		$orderid=0;

		if(!$match=Uri::match('sendemail\/(\d+)'))
		{
			$refer=Http::get('refer');

			Redirect::to($refer);			
		}

		$orderid=$match[1];

		$pageData=array('alert'=>'');



		$pageData['orderid']=$orderid;

		$pageData['orderData']=Orders::loadCache($orderid);

		if(!$pageData['orderData'])
		{
			$refer=Http::get('refer');

			Redirect::to($refer);				
		}

		$pageData['userData']=Customers::loadCache($pageData['orderData']['userid']);

		if(Request::get('btnSend'))
		{
			$send=Request::get('send');

			Mail::send(array(
			'toEmail'=>$send['email'],
			'toName'=>$pageData['userData']['firstname'].' '.$pageData['userData']['lastname'],
			'subject'=>$send['subject'],
			'content'=>$send['content']		

			));

			$pageData['alert']='<div class="alert alert-success">Send email success.</div>';	
		}


		System::setTitle('Send Email');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('systemOrderSendEmail',$pageData);

		CtrPlugin::admincpFooter();

	}

	public function cancel()
	{
		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		$orderid=0;

		if($match=Uri::match('\/order\/cancel\/(\d+)'))
		{
			$orderid=$match[1];
		}		

		if($owner=='yes')
		{
			Orders::update($orderid,array(
				'status'=>'canceled'
				)," id='$orderid'");

			Orders::saveCache($orderid);	

			Redirect::to(System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order');
		}
		else
		{
			$loadOrder=Orders::loadCache($orderid);

			if(!$loadOrder)
			{
				Redirect::to(System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order');
			}

			if((int)$userid!=(int)$loadOrder['userid'])
			{
				Redirect::to(System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order');
			}

			Orders::update($orderid,array(
				'status'=>'canceled'
				)," id='$orderid'");

			Orders::saveCache($orderid);	

        	Notifies::sendOrderCanceledEmail($orderid);

			Redirect::to(System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order');
		}
	}

	public function systemView()
	{
		$pageData=array('alert'=>'');

		$orderid=0;

		if($match=Uri::match('\/order\/view\/(\d+)'))
		{
			$orderid=$match[1];
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();
		
		if(Request::has('btnAction'))
		{	
			try {
				adminActionProcess();
				$pageData['alert']='<div class="alert alert-success">Completed your action.</div>';
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$orderData=Orders::get(array(
			'cache'=>'no',
			'where'=>"where id='$orderid'"
			));	

		if(!isset($orderData[0]['id']))
		{
			Alert::make('Order #'.$orderid.' not exists.');
		}

		$pageData['orderData']=Orders::loadCache($orderid);

		$customerID=$pageData['orderData']['userid'];

		$customerData=Customers::loadCache($customerID);

		$pageData['billing']=$customerData;

		// print_r($pageData['orderData']);die();

		// sort($pageData['orderData']['products']);

		sort($pageData['orderData']['summary']['cart_product']);


		System::setTitle('Orders');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('systemOrderView',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function userView()
	{
		$pageData=array('alert'=>'');

		$orderid=0;

		if($match=Uri::match('\/order\/view\/(\d+)'))
		{
			$orderid=$match[1];
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();


		$orderData=Orders::get(array(
			'cache'=>'no',
			'where'=>"where id='$orderid' AND userid='$userid'"
			));	

		if(!isset($orderData[0]['id']))
		{
			Alert::make(Lang::get('usercp/index.order').' #'.$orderid.Lang::get('usercp/index.notExists').'.');
		}

		$pageData['orderData']=Orders::loadCache($orderid);

		$customerID=$pageData['orderData']['userid'];

		$customerData=Customers::loadCache($customerID);

		$pageData['billing']=$customerData;

		// sort($pageData['orderData']['products']);

		sort($pageData['orderData']['summary']['cart_product']);

		System::setTitle('Orders');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('userOrderView',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function edit()
	{
		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		if($owner=='yes')
		{
			$this->systemEdit();
		}
		else
		{
			Alert::make('Page not found.');
		}
	}

	public function systemOrder()
	{
		$pageData=array('alert'=>'');

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');


		$userid=Users::getCookieUserId();

		$addWhere='';

		$addPage='';		

		if(Request::has('btnAction'))
		{	
			try {
				adminActionProcess();
				$pageData['alert']='<div class="alert alert-success">'.Lang::get('usercp/index.completedYourAction').'</div>';
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}


		$pageData['theList']=Orders::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'cache'=>'no',
			'where'=>$addWhere
			));

		$countPost=Orders::get(array(
			'cache'=>'no',
			'selectFields'=>"count(id) as totalRow",
			'where'=>$addWhere
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/plugins/privatecontroller/fastecommerce/order/index/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>30,
			'limitPage'=>5,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/30);		

		System::setTitle('Orders');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('systemOrderList',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function userOrder()
	{
		$pageData=array('alert'=>'');

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		$addWhere='';

		$addPage='';		

		if(Request::has('btnAction'))
		{	

			try {
				userActionProcess();
				$pageData['alert']='<div class="alert alert-success">'.Lang::get('usercp/index.completedYourAction').'</div>';
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if($owner!='yes')
		{
			$addWhere.=!isset($addWhere[5])?"where userid='$userid'":" AND userid='$userid'";
		}		

		$pageData['theList']=Orders::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'cache'=>'no',
			'where'=>$addWhere
			));

		$countPost=Orders::get(array(
			'cache'=>'no',
			'selectFields'=>"count(id) as totalRow",
			'where'=>$addWhere
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/plugins/privatecontroller/fastecommerce/order/index/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>30,
			'limitPage'=>5,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/30);		

		System::setTitle('Orders');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('userOrderList',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function systemEdit()
	{
		$pageData=array('alert'=>'');

		$id=0;

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$id=$match[1];
		}
		else
		{
			Alert::make('Page not found');
		}

		if(Request::has('btnSave'))
		{
			try {
				updateProcess($id);
				$pageData['alert']='<div class="alert alert-success">'.Lang::get('usercp/index.saveChangesCompleted').'</div>';
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$loadData=Products::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($loadData[0]['id']))
		{
			Alert::make('Page not found');
		}

		$pageData['productData']=$loadData[0];

		$pageData['listCat']=Categories::getRecursive(array(
			'orderby'=>'order by title asc',
			'cache'=>'no'
			));

		// $pageData['listBrand']=Brands::get(array(
		// 	'orderby'=>'order by title asc',
		// 	'cache'=>'no'
		// 	));	

		System::setTitle('Edit Product');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('productEdit',$pageData);

		CtrPlugin::view('addFooter');

		CtrPlugin::admincpFooter();
	}



}