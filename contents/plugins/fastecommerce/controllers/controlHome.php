<?php

class controlHome
{
	public function index()
	{
		CtrPlugin::model('report');
		
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

}
