<?php

function countStats()
{
	$resultData=array();

	$today=date('Y-m-d');

	$addWhere='';
	$andWhere='';



	if(Request::has('userid'))
	{
		$userid=trim(Request::get('userid',0));
		
		if((int)$userid > 0)
		{
			$addWhere=" where userid='".$userid."'";
			$andWhere=" AND userid='".$userid."'";			
		}

	}

	if(Request::has('username'))
	{
		$username=trim(Request::get('username',''));

		if(isset($username[2]))
		{
			$loadUser=Users::get(array(
				'cache'=>'no',
				'where'=>"where username='$username' OR email='$username'"
				));

			if(isset($loadUser[0]['id']))
			{
				$userid=$loadUser[0]['id'];

				$addWhere=" where userid='".$userid."'";
				$andWhere=" AND userid='".$userid."'";					
			}
		}

	}

	if(Request::has('catid'))
	{
		$catid=trim(Request::get('catid',0));
		
		if((int)$catid > 0)
		{
			$addWhere=" where catid='".$catid."'";
			$andWhere=" AND catid='".$catid."'";			
		}

	}

	$loadData=Post::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from post".$addWhere
		));

	$resultData['post']['total']=$loadData[0]['totalcount'];
	
	$loadData=Post::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from post where DATE(date_added)='$today'".$andWhere
		));

	$resultData['post']['today']=$loadData[0]['totalcount'];

	$loadData=Pages::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from post".$addWhere
		));

	$resultData['page']['total']=$loadData[0]['totalcount'];
	
	$loadData=Pages::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from post where DATE(date_added)='$today'".$andWhere
		));

	$resultData['page']['today']=$loadData[0]['totalcount'];
	
	$loadData=Post::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from post where status='1'".$andWhere
		));

	$resultData['post']['published']=$loadData[0]['totalcount'];
	
	$loadData=Post::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from post where status='0'".$andWhere
		));

	$resultData['post']['pending']=$loadData[0]['totalcount'];

	$loadData=Contactus::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from contactus"
		));

	$resultData['contactus']['total']=$loadData[0]['totalcount'];

	$loadData=Contactus::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from contactus where DATE(date_added)='$today'"
		));

	$resultData['contactus']['today']=$loadData[0]['totalcount'];

	$loadData=Users::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from users"
		));

	$resultData['users']['total']=$loadData[0]['totalcount'];

	$loadData=Users::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(id)as totalcount from users where DATE(date_added)='$today'"
		));

	$resultData['users']['today']=$loadData[0]['totalcount'];


	return $resultData;
}