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

	$paypal_email=isset(FastEcommerce::$setting['paypal_email'])?FastEcommerce::$setting['paypal_email']:'demodemo@gmail.com';
	
	$result=array(
		'method'=>'submit_form',
		'data'=>''
		
		);

	$result['data']='        
	
<form action="https://www.paypal.com/cgi-bin/webscr" id="order_submit_form" style="display:none;" method="post">
	<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="add" value="1">
	<input type="hidden" name="business" value="'.$paypal_email.'">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="item_name" value="'.FastEcommerce::$setting['store_name'].' - Order #'.$inputData['orderid'].'">
	<input type="hidden" name="item_number" value="1">
	<input type="hidden" name="amount" value="'.$inputData['total'].'">
	<input type="hidden" name="shipping" value="1.00">	
	<input type="hidden" name="charset" value="utf-8" />
  <input type="hidden" name="invoice" value="'.$inputData['orderid'].'" />
	<input type="hidden" name="currency_code" value="'.strtoupper(FastEcommerce::$setting['currency']).'">
  <input type="hidden" name="return" value="'.System::getUrl().'" />
   <input type="hidden" name="notify_url" value="'.System::getUrl().'paymentapi/paypal/notify" />
   <input type="hidden" name="cancel_return" value="'.System::getUrl().'paymentapi/paypal/cancel" />
  <input type="hidden" name="rm" value="2" /> 
  <input type="hidden" name="custom" value="'.$inputData['orderid'].'" />	
  
<input type="image" src="http://www.paypalobjects.com/en_US/i/btn/x-click-but22.gif" border="0" name="submit" width="87" height="23" alt="Make payments with PayPal - it\'s fast, free and secure!">	
	</form>	
        ';

    return $result;
}

function after_confirm_order()
{
	
}

function verify_order()
{
	
}
