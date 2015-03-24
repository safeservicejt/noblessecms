<?php


function actionProcess()
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
			Coupons::remove($id);
			break;

		case 'publish':
			Coupons::update($listID,array(
				'status'=>1
				),"couponid IN ($listID)");
			break;
		case 'unpublish':
			Coupons::update($listID,array(
				'status'=>0
				),"couponid IN ($listID)");
			break;
		
	}
}

function searchProcess($txtKeyword)
{

	$curPage=0;

	if($match=Uri::match('\/page\/(\d+)'))
	{
		$curPage=$match[1];
	}

	$resultData=array();

	$resultData['pages']=genPage('news',$curPage);	

	$txtKeyword=trim($txtKeyword);

	Request::make('txtKeyword',$txtKeyword);

	$valid=Validator::make(array(
		'txtKeyword'=>'min:1|slashes'
		));

	if(!$valid)
	{
		$resultData['coupons']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='couponid')?'id':$method;
		$method=($method=='amount')?'amountequal':$method;
		$method=($method=='amounteq')?'amountequal':$method;
		$method=($method=='freeship')?'freeshipping':$method;

		switch ($method) {
			case 'id':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where couponid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'type':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where coupon_type='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'code':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where coupon_code='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;

			case 'amountequal':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where amount='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'amountbefore':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where amount < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'amountafter':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where amount > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'before':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'after':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'on':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'startbefore':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_start < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'startafter':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_start > '$keyword'",
				'orderby'=>'order by couponid desc',
				'isHook'=>'no'
				));
				break;
			case 'starton':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_start = '$keyword'",
				'orderby'=>'order by couponid desc',
				'isHook'=>'no'
				));
				break;
			case 'endbefore':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_end < '$keyword'",
				'orderby'=>'order by couponid desc',
				'isHook'=>'no'
				));
				break;
			case 'endafter':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_end > '$keyword'",
				'orderby'=>'order by couponid desc',
				'isHook'=>'no'
				));
				break;
			case 'endon':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_end = '$keyword'",
				'orderby'=>'order by couponid desc',
				'isHook'=>'no'
				));
				break;
			case 'freeshipping':
			$resultData['coupons']=Coupons::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where freeshipping = '$keyword'",
				'orderby'=>'order by couponid desc',
				'isHook'=>'no'
				));
				break;


		}
		// print_r($matches);die();
	}
	else
	{
		$txtKeyword=String::encode($txtKeyword);

		preg_match('/"(.*?)"/i', $txtKeyword,$matches);

		$txtKeyword=$matches[1];
		
		$resultData['coupons']=Coupons::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where coupon_title LIKE '%$txtKeyword%'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	// print_r($txtKeyword);die();

	return $resultData;
}


?>