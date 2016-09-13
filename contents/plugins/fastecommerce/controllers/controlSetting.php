<?php

class controlSetting
{
	public function index()
	{
		$this->general();
	}

	public function emailtemplates()
	{
		$pageData=array('alert'=>'');


		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();
	

		System::setTitle('Email Templates');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('settingEmailTemplates',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function edit_email_template()
	{
		$pageData=array('alert'=>'');

		$template='';

		if($match=Uri::match('\/edit_email_template\/(\w+)$'))
		{
			$template=$match[1];
		}

		if(!isset($template[2]))
		{
			Alert::make('Page not found');
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		$savePath=ROOT_PATH.'contents/plugins/fastecommerce/templates/'.$template.'.html';

		$subjectPath=ROOT_PATH.'contents/plugins/fastecommerce/templates/subject_'.$template.'.html';

		if(!file_exists($savePath) || !file_exists($subjectPath))
		{
			Alert::make('Email template not found');
		}

		if(Request::has('btnSend'))
		{
			$subjectData=stripslashes(Request::get('send.subject'));

			File::create($subjectPath,$subjectData);

			$saveData=stripslashes(Request::get('send.content'));

			File::create($savePath,$saveData);

			$pageData['alert']='<div class="alert alert-success">Save changes success</div>';
		}

		$title=stripslashes(file_get_contents($subjectPath));

		$pageData['title']=$title;
	
		$pageData['content']=stripslashes(file_get_contents($savePath));

		System::setTitle($title);

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('editEmailTemplates',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function general()
	{
		$pageData=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			$send=Request::get('send');

			$affiliate_rankid=Request::get('affiliate_rankid',1);

			$rankData=AffiliatesRanks::loadCache($affiliate_rankid);

			$send['affiliate_rankid']=$rankData['id'];
			
			$send['affiliate_rank_title']=$rankData['title'];

			$send['affiliate_percent']=$rankData['commission'];

			FastEcommerce::saveSetting($send);

			$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();
	
		$pageData['setting']=FastEcommerce::loadSetting();

		$pageData['ranksList']=AffiliatesRanks::loadCacheAll();

		$pageData['listThemes']=Theme::get();

		System::setTitle('Setting General');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('settingGeneral',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function shippingrates()
	{
		$pageData=array('alert'=>'');

		if(Request::has('btnAction'))
		{	
			try {
				actionShippingRateProcess();
				$pageData['alert']='<div class="alert alert-success">Completed your action.</div>';
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}
		
		if(Request::has('btnSend'))
		{

			$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		$pageData['theList']=ShippingRates::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'cache'=>'no',			
			));

		$countPost=ShippingRates::get(array(
			'cache'=>'no',
			'selectFields'=>"count(id) as totalRow",
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/plugins/privatecontroller/fastecommerce/setting/shippingrates/',
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);	

		System::setTitle('Shipping Rates');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('listShippingRates',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function addnew_shipping_rate()
	{
		$pageData=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			$pageData['alert']='<div class="alert alert-success">Add new shipping rate success.</div>';

			try {
				insertShippingRateProcess();
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
			
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		System::setTitle('Add New Shipping Rates');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('shippingRateAdd',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function edit_shipping_rate()
	{
		$pageData=array('alert'=>'');

		$id=0;

		if($match=Uri::match('\/edit_shipping_rate\/(\d+)'))
		{
			$id=$match[1];
		}

		if(Request::has('btnAdd'))
		{
			$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';

			try {
				updateShippingRateProcess($id);
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
			
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();

		$loadData=ShippingRates::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($loadData[0]['id']))
		{
			Alert::make('This shipping rate not exists in our system.');
		}

		$pageData['theData']=$loadData[0];

		System::setTitle('Edit Shipping Rates');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('shippingRateEdit',$pageData);

		CtrPlugin::admincpFooter();
	}

	public function currency()
	{
		$pageData=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			$send=Request::get('send');

			FastEcommerce::saveSetting($send);

			$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		$userid=Users::getCookieUserId();
	
		$pageData['setting']=FastEcommerce::loadSetting();

		System::setTitle('Setting Currency');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('settingCurrency',$pageData);

		CtrPlugin::admincpFooter();
	}



}