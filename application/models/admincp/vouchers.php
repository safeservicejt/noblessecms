<?php

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
		$resultData['vouchers']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='voucherid')?'id':$method;
		$method=($method=='amount')?'amountequal':$method;
		$method=($method=='amounteq')?'amountequal':$method;

		switch ($method) {
			case 'id':
			$resultData['vouchers']=Vouchers::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where voucherid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'amountequal':
			$resultData['vouchers']=Vouchers::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where amount='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'amountbefore':
			$resultData['vouchers']=Vouchers::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where amount < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'amountafter':
			$resultData['vouchers']=Vouchers::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where amount > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'before':
			$resultData['vouchers']=Vouchers::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'after':
			$resultData['vouchers']=Vouchers::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'on':
			$resultData['vouchers']=Vouchers::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added = '$keyword'",
				'orderby'=>'order by date_added desc',
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
		
		$resultData['vouchers']=Vouchers::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where code = '$txtKeyword'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	// print_r($txtKeyword);die();

	return $resultData;
}



?>