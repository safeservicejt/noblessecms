<?php

function processRegister()
{
    $alert='<div class="alert alert-warning">Error. Check your information again,pls!</div>';

	$captchaStatus=Captcha::verify();

	if(!$captchaStatus)
	{
    	$alert='<div class="alert alert-warning">Wrong captcha verify!</div>';

    	return $alert;
	}


	$send=Request::get('send');

	$address=Request::get('address');

		// print_r($send);
	$validSend=Validator::make(array(
		'send.firstname'=>'min:2|max:30|slashes',
		'send.lastname'=>'min:2|max:30|slashes',
		'send.email'=>'min:5|max:150|slashes',
		'send.password'=>'min:5|max:50|slashes',
		'send.repassword'=>'min:5|max:50|slashes'
		));

	$validAddress=Validator::make(array(
		'address.address_1'=>'min:2|max:150|slashes',
		'address.city'=>'min:2|max:50|slashes',
		'address.country'=>'min:2|max:50|slashes',
		'address.postcode'=>'min:2|max:15|slashes'
		));

	if($validAddress==true)
	{
		$send['password']=md5($send['password']);

		unset($send['repassword']);
		
		if($userid=Users::insert($send))
		{

			$address['userid']=$userid;

			Address::insert($address);	

			$post=array(
				'userid'=>$userid,
				'commission'=>GlobalCMS::$setting['default_affiliate_commission']
				);

			Affiliate::insert($post);

			Users::registerEmail();

    		$alert='<div class="alert alert-success">Success. You have been complete register your account! <a href="'.USERCP_URL.'login">Go to login page</a>.</div>';				
		}

	}


	return $alert;

}

?>