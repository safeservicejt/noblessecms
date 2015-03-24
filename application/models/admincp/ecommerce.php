<?php

function statsProcess($method)
{
	$resultData='';

	$method=strtolower($method);

	switch ($method) {

		case 'summarystats':
		// die('dfdf');

		$resultData=summaryStats();
			# code...
			break;
		case 'lastorders':
		// die('dfdf');
		Model::load('admincp/orders');

		$resultData=lastOrders(5);
			# code...
			break;

		case 'lastreviews':
		// die('dfdf');
		Model::load('admincp/reviews');

		$resultData=lastReviews(5);
			# code...
			break;
		case 'lastearned':
		// die('dfdf');
		Model::load('admincp/affiliate');

		$resultData=lastEarned(5);
			# code...
			break;
		case 'lastcommision':
		// die('dfdf');
		Model::load('admincp/affiliate');

		$resultData=lastCommision(5);
			# code...
			break;
		case 'lastsales':
		// die('dfdf');
		Model::load('admincp/products');

		$resultData=lastSales(5);
			# code...
			break;
		case 'topprodviews':
		// die('dfdf');
		Model::load('admincp/products');

		$resultData=topProdViews(5);
			# code...
			break;

	}

	echo $resultData;die();
}

function summaryStats()
{
	$resultData=array();

	if($loadData=Cache::loadKey('summaryeStats',120))
	{
		// $resultData=json_decode($loadData,true);
		$resultData=$loadData;

		return $resultData;
	}


	$startToday=date('Y-m-d 00:00:00');
	$endToday=date('Y-m-d h:i:s');

	$query=Database::query("select count(orderid) as totalID from orders where date_added BETWEEN '$startToday' AND '$endToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayOrders']=$row['totalID'];

	$query=Database::query("select count(orderid) as totalID from orders");

	$row=Database::fetch_assoc($query);

	$resultData['totalOrders']=$row['totalID'];

	$query=Database::query("select count(orderid) as totalID from orders where order_status='completed' OR order_status='success'");

	$row=Database::fetch_assoc($query);

	$resultData['successOrders']=$row['totalID'];

	$query=Database::query("select count(orderid) as totalID from orders where order_status='pending'");

	$row=Database::fetch_assoc($query);

	$resultData['pendingOrders']=$row['totalID'];

	$query=Database::query("select count(orderid) as totalID from orders where order_status='cancel'");

	$row=Database::fetch_assoc($query);

	$resultData['cancelOrders']=$row['totalID'];

	$query=Database::query("select count(productid) as totalID from products");

	$row=Database::fetch_assoc($query);

	$resultData['totalProd']=$row['totalID'];

	$query=Database::query("select count(productid) as totalID from products where date_discount >= '$startToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayDiscount']=$row['totalID'];

	$query=Database::query("select sum(viewed) as totalID from products");

	$row=Database::fetch_assoc($query);

	$resultData['totalProdViews']=$row['totalID'];

	$query=Database::query("select count(couponid) as totalID from coupons");

	$row=Database::fetch_assoc($query);

	$resultData['totalCoupons']=$row['totalID'];

	$query=Database::query("select count(couponid) as totalID from coupons where date_start >= '$startToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayCoupons']=$row['totalID'];

	$query=Database::query("select count(voucherid) as totalID from gift_vouchers");

	$row=Database::fetch_assoc($query);

	$resultData['totalVouchers']=$row['totalID'];

	$query=Database::query("select count(reviewid) as totalID from reviews where date_added >= '$startToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayReviews']=$row['totalID'];

	$query=Database::query("select count(reviewid) as totalID from reviews");

	$row=Database::fetch_assoc($query);

	$resultData['totalReviews']=$row['totalID'];

	$query=Database::query("select count(reviewid) as totalID from reviews where status='0'");

	$row=Database::fetch_assoc($query);

	$resultData['pendingReviews']=$row['totalID'];

	$query=Database::query("select count(reviewid) as totalID from reviews where status='1'");

	$row=Database::fetch_assoc($query);

	$resultData['approvedReviews']=$row['totalID'];

	$query=Database::query("select count(requestid) as totalID from request_payments where status='1'");

	$row=Database::fetch_assoc($query);

	$resultData['completeRequestPayment']=$row['totalID'];

	$query=Database::query("select count(requestid) as totalID from request_payments where status='0'");

	$row=Database::fetch_assoc($query);

	$resultData['pendingRequestPayment']=$row['totalID'];

	$query=Database::query("select sum(earned) as totalID from affiliate");

	$row=Database::fetch_assoc($query);

	$getData=Currency::parsePrice($row['totalID']);

	$resultData['currentEarned']=$getData['format'];


	Cache::saveKey('summaryeStats',json_encode($resultData));

	return json_encode($resultData);
}
?>