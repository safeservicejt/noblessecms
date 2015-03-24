<?php


function paymentProcess()
{
	$resultData='payment/';

	if(!$match=Uri::match('payment\/(\w+)'))
	{
		Alert::make('Page not found');
	}

	if(!Session::has('orderid'))
	{
		Alert::make('Page not found');
	}

	$pageName=strtolower($match[1]);

	switch ($pageName) {
		case 'verify':

			if(!$matchDir=Uri::match('verify\/(\w+)'))
			{
				die('ERROR');
			}

			verifyProcess($matchDir[1]);

			break;
		case 'completed':
			
			$resultData.='completed';
			break;

		case 'cancel':

			$orderid=Session::get('orderid');

			Session::forget('cart');

			Orders::update($orderid,array('order_status'=>'cancel'));
			
			$resultData.='cancel';
			break;
		
		default:
			Alert::make('Page not found');
			break;
	}


	return $resultData;
}

function verifyProcess($dirName)
{
	$path=ROOT_PATH.'contents/paymentmethods/'.$dirName.'/index.php';

	if(!file_exists($path))
	{
		die('ERROR');
	}

	include($path);

	$func='verifyPayment_'.$dirName;

	if(!function_exists($func))
	{
		die('ERROR');
	}

	$func();
}


?>