<?php

class controlCustomer
{
	public function index()
	{
		$pageData=array('alert'=>'');

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		if($owner!='yes')
		{
			Alert::make('Page not found');
		}	

		$userid=Users::getCookieUserId();

		$addWhere='';

		$addPage='';		

		if(Request::has('btnAction'))
		{	
			try {
				actionProcess();
				$pageData['alert']='<div class="alert alert-success">Completed your action.</div>';
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

	

		$pageData['theList']=Customers::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'cache'=>'no',
			'where'=>$addWhere
			));

		$total=count($pageData['theList']);

		for ($i=0; $i < $total; $i++) { 
			$theID=$pageData['theList'][$i]['userid'];

			$userData=Customers::loadCache($theID);

			$pageData['theList'][$i]=array_merge($pageData['theList'][$i],$userData);
		}

		$countPost=Customers::get(array(
			'cache'=>'no',
			'selectFields'=>"count(id) as totalRow",
			'where'=>$addWhere
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/plugins/privatecontroller/fastecommerce/affiliate/index/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);		

		System::setTitle('Customers');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('customersList',$pageData);

		CtrPlugin::admincpFooter();
	}
	public function edit()
	{
		$pageData=array('alert'=>'');

		$id=0;

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$id=$match[1];
		}
		else
		{
			// Alert::make('Page not found');
		}

		if(Request::has('btnSave'))
		{
			try {
				updateProcess($id);
				$pageData['alert']='<div class="alert alert-success">Save changes completed</div>';
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$loadData=Customers::loadCache($id);

		if(!isset($loadData['userid']))
		{
			Alert::make('Page not found');
		}

		$alert=$pageData['alert'];

		$pageData=$loadData;

		$pageData['alert']=$alert;

		$pageData['ranksList']=AffiliatesRanks::loadCacheAll();

		// $pageData['listBrand']=Brands::get(array(
		// 	'orderby'=>'order by title asc',
		// 	'cache'=>'no'
		// 	));	

		System::setTitle('Edit Customer');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('customerEdit',$pageData);

		CtrPlugin::view('addFooter');

		CtrPlugin::admincpFooter();
	}



}