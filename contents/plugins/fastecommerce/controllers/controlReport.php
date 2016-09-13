<?php

class controlReport
{
	public function index()
	{
		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		if($owner=='yes')
		{
			$this->adminstats();
		}
		else
		{
			$this->customerstats();
		}

	}


	public function adminstats()
	{
		$pageData=array();

		$pageData=adminStatsSummary();

		$pageData['listOrders']=Orders::get(array(
			'limitShow'=>20,
			'cache'=>'no',
			'cacheTime'=>60,
			));
		
		System::setTitle('Statistics');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('adminStats',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function customerstats()
	{
		$userid=Users::getCookieUserId();

		$pageData=array();

		$pageData=customerStatsSummary();

		$pageData['listOrders']=Orders::get(array(
			'limitShow'=>20,
			'cache'=>'no',
			'cacheTime'=>60,
			'where'=>"where userid='$userid'"
			));

		System::setTitle('Statistics');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('customerStats',$pageData);

		CtrPlugin::admincpFooter();
	}




}