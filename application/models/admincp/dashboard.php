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

			if(isset($loadUser[0]['userid']))
			{
				$userid=$loadUser[0]['userid'];

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
		'query'=>"select count(postid)as totalcount from ".Database::getPrefix()."post".$addWhere
		));

	$resultData['post']['total']=$loadData[0]['totalcount'];
	
	$loadData=Post::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(postid)as totalcount from ".Database::getPrefix()."post where DATE(date_added)='$today'".$andWhere
		));

	$resultData['post']['today']=$loadData[0]['totalcount'];
	
	$loadData=Post::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(postid)as totalcount from ".Database::getPrefix()."post where status='1'".$andWhere
		));

	$resultData['post']['published']=$loadData[0]['totalcount'];
	
	$loadData=Post::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(postid)as totalcount from ".Database::getPrefix()."post where status='0'".$andWhere
		));

	$resultData['post']['pending']=$loadData[0]['totalcount'];

	$loadData=Comments::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(commentid)as totalcount from ".Database::getPrefix()."comments"
		));

	$resultData['comments']['total']=$loadData[0]['totalcount'];

	$loadData=Comments::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(commentid)as totalcount from ".Database::getPrefix()."comments where DATE(date_added)='$today'"
		));

	$resultData['comments']['today']=$loadData[0]['totalcount'];

	$loadData=Comments::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(commentid)as totalcount from ".Database::getPrefix()."comments where status='1'"
		));

	$resultData['comments']['approved']=$loadData[0]['totalcount'];

	$loadData=Comments::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(commentid)as totalcount from ".Database::getPrefix()."comments where status='0'"
		));

	$resultData['comments']['pending']=$loadData[0]['totalcount'];

	$loadData=Contactus::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(contactid)as totalcount from ".Database::getPrefix()."contactus"
		));

	$resultData['contactus']['total']=$loadData[0]['totalcount'];

	$loadData=Contactus::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(contactid)as totalcount from ".Database::getPrefix()."contactus where DATE(date_added)='$today'"
		));

	$resultData['contactus']['today']=$loadData[0]['totalcount'];

	$loadData=Users::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(userid)as totalcount from ".Database::getPrefix()."users"
		));

	$resultData['users']['total']=$loadData[0]['totalcount'];

	$loadData=Users::get(array(
		'cache'=>'yes',
		'cacheTime'=>30,
		'query'=>"select count(userid)as totalcount from ".Database::getPrefix()."users where DATE(date_added)='$today'"
		));

	$resultData['users']['today']=$loadData[0]['totalcount'];


	return $resultData;
}