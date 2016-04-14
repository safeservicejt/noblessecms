<?php

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
