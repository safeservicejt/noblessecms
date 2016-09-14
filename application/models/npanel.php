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

function registerProcess()
{
	$valid=Validator::make(array(
		'send.firstname'=>'min:1|slashes',
		'send.lastname'=>'min:1|slashes',
		'send.email'=>'min:4|slashes',
		'send.username'=>'min:5|slashes',
		'send.password'=>'min:5|slashes',
		'send.repassword'=>'min:5|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request. Check your information again!");
		
	}

	if(System::getSetting('system_captcha')=='enable')
	{
		if(!Captcha::verify())
		{
			throw new Exception("Wrong captcha characters.");
			
		}		
	}


	$send=Request::get('send');

	$username=$send['username'];

	$email=$send['email'];

	$password=$send['password'];

	$repassword=$send['repassword'];

	$firstname=$send['firstname'];

	$lastname=$send['lastname'];

	$loadUser=Users::get(array(
		'cache'=>'no',
		'where'=>"where (username='$username' OR email='$username') OR (username='$email' OR email='$email') "
		));

	if(isset($loadUser[0]['email']))
	{
		throw new Exception('This user exists in our system.');		
	}

	$insertData=array(
		'email'=>$email,
		'username'=>$username,
		'password'=>$password,
		'firstname'=>$firstname,
		'lastname'=>$lastname
		);
	
	try {
		Users::makeRegister($insertData);
	} catch (Exception $e) {
		throw new Exception($e->getMessage());
	}


	// Redirect::to(System::getAdminUrl());
}


function forgotProcess()
{
	$valid=Validator::make(array(
		'send.email'=>'email|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
		
	}

	if(System::getSetting('system_captcha')=='enable')
	{
		if(!Captcha::verify())
		{
			throw new Exception("Wrong captcha characters.");
			
		}		
	}


	$email=Request::get('send.email');

	try {
		Users::forgotPassword($email);
	} catch (Exception $e) {
		throw new Exception($e->getMessage());
	}
}
