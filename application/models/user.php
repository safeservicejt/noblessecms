<?php

function apiProcess($keyName='')
{
	if($keyName=='login')
	{
		if(isset($_COOKIE['userid']))
		{
			throw new Exception("You have been loggedin.");

		}

		$username=Request::get('username','');

		$password=Request::get('password','');

		try {

			Users::makeLogin($username,$password);

			return json_encode(array('error'=>'no','loggedin'=>'yes'));

		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}
	}
	elseif($keyName=='register')
	{
		try {

			$id=Users::makeRegister();

			return json_encode(array('error'=>'no','userid'=>$id));

		} catch (Exception $e) {

			throw new Exception($e->getMessage());

		}
	}
	elseif($keyName=='verify_email')
	{
		$code=Request::get('verify_code','');

		if($code=='')
		{
			throw new Exception("Error Processing Request");
		}

		$loadData=Users::get(array(
			'where'=>"where verify_code='$code'"
			));

		if(isset($loadData[0]['userid']))
		{
			Users::update($loadData[0]['userid'],array(
				'verify_code'=>''
				));

			Redirect::to(ROOT_URL);

			// Users::sendNewPassword($loadData[0]['email']);
		}
		else
		{
			throw new Exception("Verify link not valid.");
			
		}
	}
	elseif($keyName=='verify_forgotpassword')
	{
		$code=Request::get('verify_code','');

		if($code=='')
		{
			throw new Exception("Error Processing Request");
		}

		$loadData=Users::get(array(
			'where'=>"where forgot_code='$code'"
			));

		if(isset($loadData[0]['userid']))
		{
			Users::update($loadData[0]['userid'],array(
				'forgot_code'=>''
				));

			Users::sendNewPassword($loadData[0]['email']);

			Redirect::to(ROOT_URL);
		}
		else
		{
			throw new Exception("Verify code not valid.");
		}
	}
	else
	{
		throw new Exception('We not support api: '.$keyName);
	}
}