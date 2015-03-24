<?php

//function must return string: completed|error|show_redirect_button.If false, customer will return checkout page
//after_click_confirm_check_out


Paymentmethods::$load['title']='Cash on delivery';

Paymentmethods::$load['setting']='setting_cashondelivery';

Paymentmethods::install('install_cashondelivery');

function install_cashondelivery()
{

	// Paymentmethods::$load['require_form_on_checkout']='require_form_cashondelivery';

	// Paymentmethods::$load['after_click_confirm_check_out']='after_click_confirm_check_out_cashondelivery';

}


function setting_cashondelivery()
{
	// echo 'OK setting';
}

function after_click_confirm_check_out_cashondelivery($orderData=array())
{
	// $resultData=array(

	// 	'status'=>'error',
	// 	'error'=>'Error message'

	// 	);
	$resultData=array(
		'status'=>'completed'
		);

	// $resultData=array(

	// 	'status'=>'process_page',

	// 	'content'=>'<img src="http://test.vn/project/2014/noblessecms/contents/themes/fruits/images/logo.png" />'

	// 	);

	return $resultData;
}


function require_form_cashondelivery()
{
	return '

	<p>
	<label>Enter your name</label>
	<input type="text" name="customerName" class="form-control" />
	</p>

	';
}


?>