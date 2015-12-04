<?php

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

	if(!Captcha::verify())
	{
		throw new Exception("Wrong captcha characters.");
		
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

?>