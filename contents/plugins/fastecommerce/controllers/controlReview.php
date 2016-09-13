<?php

class controlReview
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


		$pageData['theList']=Reviews::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'cache'=>'no'
			));

		$totalRow=count($pageData['theList']);

		for ($i=0; $i < $totalRow; $i++) { 
			$id=$pageData['theList'][$i]['productid'];

			$userid=$pageData['theList'][$i]['userid'];

			$prodData=Products::loadCache($id);

			$userData=Users::loadCache($userid);

			// print_r($prodData);die();

			if(!$prodData || !$userData)
			{
				continue;
			}

			$pageData['theList'][$i]['product']=$prodData;

			$pageData['theList'][$i]['user']=$userData;

		}

		$countPost=Reviews::get(array(
			'cache'=>'no',
			'selectFields'=>"count(id) as totalRow",
			'where'=>$addWhere
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/plugins/privatecontroller/fastecommerce/review/index/'.$addPage,
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);		

		System::setTitle('Reviews');

		CtrPlugin::admincpHeader();

		CtrPlugin::admincpLeft();

		CtrPlugin::view('addHeader');

		CtrPlugin::view('reviewList',$pageData);

		CtrPlugin::admincpFooter();
	}



}