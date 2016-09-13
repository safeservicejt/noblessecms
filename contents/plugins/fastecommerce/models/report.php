<?php

function adminStatsSummary()
{
	$result=array(
		'order'=>0,
		'sale'=>0,
		'customer'=>0,
		'product'=>0,
		);

	$loadData=Orders::get(array(
		'cache'=>'no',
		'selectFields'=>'count(id)as totalRow'
		));

	$result['order']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	$loadData=Orders::get(array(
		'cache'=>'no',
		'where'=>"where status<>'draft'",
		'selectFields'=>'sum(total)as totalRow'
		));

	$result['sale']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	$loadData=Users::get(array(
		'cache'=>'no',
		'selectFields'=>'count(userid)as totalRow'
		));

	$result['customer']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	$loadData=Products::get(array(
		'cache'=>'no',
		'selectFields'=>'count(id)as totalRow'
		));

	$result['product']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	return $result;
}

function customerStatsSummary()
{

	$userid=Users::getCookieUserId();

	$result=array(
		'order'=>0,
		'sale'=>0,
		'customer'=>0,
		'product'=>0,
		);

	$loadData=Orders::get(array(
		'cache'=>'no',
		'where'=>"where userid='$userid'",
		'selectFields'=>'count(id)as totalRow'
		));

	$result['order']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	$loadData=Orders::get(array(
		'cache'=>'no',
		'where'=>"where userid='$userid' AND status='completed'",
		'selectFields'=>'count(id)as totalRow'
		));

	$result['order_pending']=isset($loadData[0]['totalRow'])?$loadData[0]['totalRow']:0;

	$loadData=Customers::get(array(
		'cache'=>'no',
		'where'=>"where userid='$userid'",
		));

	$result['balance']=isset($loadData[0]['balance'])?$loadData[0]['balance']:0;

	$result['commission']=isset($loadData[0]['commission'])?$loadData[0]['commission']:0;

	return $result;
}