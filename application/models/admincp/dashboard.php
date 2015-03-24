<?php

function statsProcess($method)
{
	$resultData='';

	$method=strtolower($method);

	switch ($method) {

		case 'topviews':
		// die('dfdf');
		Model::load('admincp/post');

		$resultData=topViews(5);
			# code...
			break;
		case 'topcomments':
		// die('dfdf');
		Model::load('admincp/post');

		$resultData=topComments(5);
			# code...
			break;
		case 'lastpostcomments':
		// die('dfdf');
		Model::load('admincp/post');

		$resultData=lastComments(5);
			# code...
			break;
		case 'lastcontactus':
		// die('dfdf');
		Model::load('admincp/contactus');

		$resultData=lastContactus(5);
			# code...
			break;
		case 'summarystats':
		// die('dfdf');
		// Model::load('admincp/contactus');

		$resultData=summaryStats();
			# code...
			break;

	}

	echo $resultData;die();
}



function summaryStats()
{
	$resultData=array();

	if($loadData=Cache::loadKey('summaryStats',120))
	{
		$resultData=$loadData;

		return $resultData;
	}


	$startToday=date('Y-m-d 00:00:00');
	$endToday=date('Y-m-d h:i:s');

	$query=Database::query("select count(postid) as totalID from post where date_added BETWEEN '$startToday' AND '$endToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayPost']=$row['totalID'];

	$query=Database::query("select count(postid) as totalID from post");

	$row=Database::fetch_assoc($query);

	$resultData['totalPost']=$row['totalID'];

	$query=Database::query("select count(postid) as totalID from post where status='1'");

	$row=Database::fetch_assoc($query);

	$resultData['publishPost']=$row['totalID'];

	$query=Database::query("select count(postid) as totalID from post where status='0'");

	$row=Database::fetch_assoc($query);

	$resultData['pendingPost']=$row['totalID'];

	$query=Database::query("select count(commentid) as totalID from comments where  date_added BETWEEN '$startToday' AND '$endToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayComment']=$row['totalID'];

	$query=Database::query("select count(commentid) as totalID from comments");

	$row=Database::fetch_assoc($query);

	$resultData['totalComment']=$row['totalID'];

	$query=Database::query("select count(commentid) as totalID from comments where status = '1'");

	$row=Database::fetch_assoc($query);

	$resultData['approvedComment']=$row['totalID'];

	$query=Database::query("select count(commentid) as totalID from comments where status = '0'");

	$row=Database::fetch_assoc($query);

	$resultData['pendingComment']=$row['totalID'];

	$query=Database::query("select count(contactid) as totalID from contactus where date_added BETWEEN '$startToday' AND '$endToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayContact']=$row['totalID'];

	$query=Database::query("select count(contactid) as totalID from contactus");

	$row=Database::fetch_assoc($query);

	$resultData['totalContact']=$row['totalID'];

	$query=Database::query("select count(userid) as totalID from users where date_added BETWEEN '$startToday' AND '$endToday'");

	$row=Database::fetch_assoc($query);

	$resultData['todayUsers']=$row['totalID'];

	$query=Database::query("select count(userid) as totalID from users");

	$row=Database::fetch_assoc($query);

	$resultData['totalUsers']=$row['totalID'];

	$query=Database::query("select count(userid) as totalID from users where groupid='8'");

	$row=Database::fetch_assoc($query);

	$resultData['pendingUsers']=$row['totalID'];

	Cache::saveKey('summaryStats',json_encode($resultData));

	return json_encode($resultData);
}

?>