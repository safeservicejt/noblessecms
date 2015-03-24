<?php

function apiUsers()
{
    if(!$matches=Uri::match('api\/users\/(\w+)'))
    {
    	die('ERROR');
    }

    switch ($matches[1]) {
    	case 'valid':
    		isUser();
    		break;

     	case 'login':
    		setLogin();
    		break;

    	case 'changepassword':
    		changePassword();
    		break;


    }	
}

function isUser()
{
	$uname='';

	$pword='';

	if(!$matches=Uri::match('api\/users\/valid\/(.*?\@\w+\.\w+)\/(.*?)$'))
	{
		$uname=Request::get('email');

		$pword=Request::get('password');

	}
	else
	{
		$uname=$matches[1];

		$pword=$matches[2];

		Request::make('email',$uname);

		Request::make('password',$pword);
	}

	// die($uname.'----'.$pword);

	$valid=Users::isUser($uname,$pword);

	if(!$valid)
	{
		die('ERROR');
	}

	die('OK');
}
function setLogin()
{
	$uname='';

	$pword='';

	if(!$matches=Uri::match('api\/users\/login\/(.*?\@\w+\.\w+)\/(.*?)$'))
	{
		$uname=Request::get('email');

		$pword=Request::get('password');

	}
	else
	{
		$uname=$matches[1];

		$pword=$matches[2];

		Request::make('email',$uname);

		Request::make('password',$pword);
	}

	// die($uname.'----'.$pword);

	$valid=Users::makeLogin();

	if(!$valid)
	{
		die('ERROR');
	}

	die('OK');
}

function changePassword()
{
	$newPassword='';

	$userid=0;

	if(!$matches=Uri::match('api\/users\/changepassword\/(\d+)\/(.*?)$'))
	{
		$userid=Request::get('userid');

		$newPassword=Request::get('password');

	}
	else
	{
		$userid=$matches[1];

		$newPassword=$matches[2];

		Request::make('userid',$userid);

		Request::make('password',$newPassword);

	}

    $valid=Validator::make(array(
    	'userNodeid'=>'min:1|slashes',
   		'password'=>'min:1|slashes'
    ));	

	if(!$valid)
	{
		die('ERROR');
	}

	$user=Users::changePassword($userid,$newPassword);

	if(!$user)
	{
		die('ERROR');		
	}

	die('OK');	
}

?>