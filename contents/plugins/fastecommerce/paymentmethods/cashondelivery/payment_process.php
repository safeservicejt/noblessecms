<?php

function required_form()
{
	return '';
}

function check_submit_form()
{

}

// After click Checkout button & order information is valid.

function is_redirect_page()
{
	return true;
}

function redirect_page_content()
{
	return '';
}

function after_insert_order()
{

}

function before_insert_order()
{
	
}


function before_confirm_order($inputData=array())
{
	$result=array(
		'method'=>'none',
		'data'=>''
		
		);

	$orderid=$inputData['orderid'];

	Orders::update($orderid,array(
		'status'=>'pending'
		));

	Orders::saveCache($orderid);

    return $result;
}

function after_confirm_order()
{
	
}

function verify_order()
{
	
}
