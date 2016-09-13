<?php


function actionRankProcess()
{
	$action=Request::get('action');

	$id=Request::get('id');

	if((int)$id <= 0)
	{
		return false;
	}

	$listID="'".implode("','",$id)."'";

	switch ($action) {
		case 'delete':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}
			
			AffiliatesRanks::remove($id);

			AffiliatesRanks::saveCacheAll();

			break;


		case 'activate':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			AffiliatesRanks::update($id,array(
				'status'=>'1'
				),"id IN ($listID)");

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				$theID=$id[$i];

				AffiliatesRanks::saveCache($theID);
			}

			AffiliatesRanks::saveCacheAll();

			break;

		case 'deactivate':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			AffiliatesRanks::update($id,array(
				'status'=>'0'
				),"id IN ($listID)");

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				$theID=$id[$i];

				AffiliatesRanks::saveCache($theID);
			}

			AffiliatesRanks::saveCacheAll();

			break;

	}
}


function updateRankProcess($rankid)
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.commission'=>'min:1|number|slashes',
		'send.orders'=>'min:1|number|slashes',
		'send.status'=>'min:1|slashes',

		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
		
	}

	if(!AffiliatesRanks::update($rankid,$send))
	{
		throw new Exception(Database::$error);
		
	}

	AffiliatesRanks::saveCache($rankid);
	
	AffiliatesRanks::saveCacheAll();

}

function addRankProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.commission'=>'min:1|number|slashes',
		'send.orders'=>'min:1|number|slashes',
		'send.status'=>'min:1|slashes',

		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
		
	}

	if(!$id=AffiliatesRanks::insert($send))
	{
		throw new Exception(Database::$error);
		
	}

	AffiliatesRanks::saveCache($id);
	
	AffiliatesRanks::saveCacheAll();
}

function addCollectionProcess()
{
	$urls=Request::get('urls');

    if(!preg_match_all('/\-(\d+)\.html/i', $urls, $matches))
    {
        throw new Exception('Data not valid.');
        
    }

	$userid=Users::getCookieUserId();

	$listID="'".implode("','", $matches[1])."'";

	$colHas=CollectionsProducts::saveCache($userid,$listID);

	return 'Create collection success. Click <a href="'.CollectionsProducts::url($colHas).'.html" target="_blank">here</a> to view your collection!';
}

function withdrawProcess()
{
	$money_request=(double)Request::get('money_request',0);

	if($money_request==0)
	{
		throw new Exception(Lang::get('usercp/index.moneyMustLargeThan').'0.00');
	}

	$userid=Users::getCookieUserId();

	$userData=Customers::loadCache($userid);

	if((double)$userData['balance']<(double)$money_request)
	{
		throw new Exception(Lang::get('usercp/index.youNotEnoughMoneyForCreateRequest'));
		
	}

	$balance=(double)$userData['balance']-(double)$money_request;

	Customers::update($userid,array(
		'balance'=>$balance
		));

	Customers::saveCache($userid);


}

function reportSystemSummary()
{

	$userid=Users::getCookieUserId();

	$result=array(
		'clicks'=>0,
		'sale'=>0,
		'customer'=>0,
		'withdrawed'=>0,
		);

	$result['clicks']=Affiliates::getClicks($userid);

	$result['withdrawed']=(double)Affiliates::getKey('withdrawed',$userid);

	$loadData=Orders::get(array(
		'cache'=>'no',
		'where'=>"where userid='$userid' AND status='completed'",
		'selectFields'=>'count(id)as totalRow'
		));

	$result['order_completed']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	$loadData=Customers::get(array(
		'cache'=>'no',
		'where'=>"where userid='$userid'",
		));

	$result['balance']=isset($loadData[0]['balance'])?$loadData[0]['balance']:0;

	$result['commission']=isset($loadData[0]['commission'])?$loadData[0]['commission']:0;

	return $result;
}

function reportSummary()
{

	$userid=Users::getCookieUserId();

	$result=array(
		'clicks'=>0,
		'sale'=>0,
		'customer'=>0,
		'withdrawed'=>0,
		);

	$result['clicks']=Affiliates::getClicks($userid);

	$result['withdrawed']=(double)Affiliates::getKey('withdrawed',$userid);

	$loadData=Orders::get(array(
		'cache'=>'no',
		'where'=>"where userid='$userid' AND status='completed'",
		'selectFields'=>'count(id)as totalRow'
		));

	$result['order_completed']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	$loadData=Customers::get(array(
		'cache'=>'no',
		'where'=>"where userid='$userid'",
		));

	$result['balance']=isset($loadData[0]['balance'])?$loadData[0]['balance']:0;

	$result['commission']=isset($loadData[0]['commission'])?$loadData[0]['commission']:0;

	return $result;
}