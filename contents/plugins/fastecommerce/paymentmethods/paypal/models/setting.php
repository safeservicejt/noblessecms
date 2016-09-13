<?php

function saveProcess()
{
	$paypal_email=Request::get('paypal_email','');

	if($paypal_email=='')
	{
		throw new Exception('Data not valid.');
		
	}

	FastEcommerce::saveSetting(array(
		'paypal_email'=>$paypal_email
		));
}