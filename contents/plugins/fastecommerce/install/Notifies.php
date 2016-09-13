<?php

class Notifies
{

	public static function sendNewOrderEmail($orderid)
	{
		if(isset(FastEcommerce::$setting['allow_send_order_notify_to_admin']) || FastEcommerce::$setting['allow_send_order_notify_to_admin']=='yes')
		{
			$loadOrder=Orders::loadCache($orderid);

			if(!isset($loadOrder['id']))
			{
				throw new Exception('Order ID not exists.');
				
			}

			$customerID=$loadOrder['userid'];

			$loadUser=Customers::loadCache($customerID);

			if(!$loadUser)
			{
				throw new Exception('Userid not exists.');
			}

			$orderTemplate=EmailTemplates::getContent('new_order');

			$replaces=array(
				'/(\{\{(\w+)\}\})/i'=>"{{ $2 }}",
				'/(\{\{ orderid \}\})/i'=>$loadOrder['id'],
				'/(\{\{ shop_name \}\})/i'=>FastEcommerce::$setting['store_name'],
				'/(\{\{ shipping_firstname \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_lastname \}\})/i'=>$loadOrder['shipping_lastname'],
				'/(\{\{ payment_method \}\})/i'=>$loadOrder['summary']['payment_method'],
				'/(\{\{ shipping_method \}\})/i'=>$loadOrder['summary']['shipping_method'],
				'/(\{\{ shipping_address_street \}\})/i'=>$loadOrder['shipping_address1'].'|'.$loadOrder['shipping_address2'],
				'/(\{\{ shipping_address_city \}\})/i'=>$loadOrder['shipping_city'],
				'/(\{\{ shipping_address_province \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_address_country \}\})/i'=>$loadOrder['shipping_country'],
				'/(\{\{ shipping_address_phone \}\})/i'=>$loadOrder['shipping_phone'],
				'/(\{\{ shipping_address_zip \}\})/i'=>$loadOrder['shipping_postcode'],
				'/(\{\{ order_url \}\})/i'=>$loadOrder['url'],
				'/(\{\{ site_url \}\})/i'=>System::getUrl(),

				);

			$content=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['content']);

			$subject=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['subject']);

			try {
				Mail::send(array(
				'toEmail'=>FastEcommerce::$setting['order_notify_email'],
				'toName'=>FastEcommerce::$setting['store_name'],
				'subject'=>$subject,
				'content'=>$content
				));
			} catch (Exception $e) {
				// throw new Exception($e->getMessage());
				Logs::insert(array(
					'content'=>'Failed sent email "'.$subject.'" to '.FastEcommerce::$setting['order_notify_email']
					));
			}			
		}


	}

	public static function sendOrderCanceledEmail($orderid)
	{
		if(isset(FastEcommerce::$setting['allow_send_order_notify_to_customer']) || FastEcommerce::$setting['allow_send_order_notify_to_customer']=='yes')
		{
			$loadOrder=Orders::loadCache($orderid);

			if(!isset($loadOrder['id']))
			{
				throw new Exception('Order ID not exists.');
				
			}

			$customerID=$loadOrder['userid'];

			$loadUser=Customers::loadCache($customerID);

			if(!$loadUser)
			{
				throw new Exception('Userid not exists.');
			}

			$orderTemplate=EmailTemplates::getContent('order_canceled');

			$replaces=array(
				'/(\{\{\w+\}\})/i'=>"{{ $2 }}",
				'/(\{\{ orderid \}\})/i'=>$loadOrder['id'],
				'/(\{\{ shop_name \}\})/i'=>FastEcommerce::$setting['store_name'],
				'/(\{\{ shipping_firstname \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_lastname \}\})/i'=>$loadOrder['shipping_lastname'],
				'/(\{\{ payment_method \}\})/i'=>$loadOrder['summary']['payment_method'],
				'/(\{\{ shipping_method \}\})/i'=>$loadOrder['summary']['shipping_method'],
				'/(\{\{ shipping_address_street \}\})/i'=>$loadOrder['shipping_address1'].'|'.$loadOrder['shipping_address2'],
				'/(\{\{ shipping_address_city \}\})/i'=>$loadOrder['shipping_city'],
				'/(\{\{ shipping_address_province \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_address_country \}\})/i'=>$loadOrder['shipping_country'],
				'/(\{\{ shipping_address_phone \}\})/i'=>$loadOrder['shipping_phone'],
				'/(\{\{ shipping_address_zip \}\})/i'=>$loadOrder['shipping_postcode'],
				'/(\{\{ order_url \}\})/i'=>$loadOrder['url'],
				'/(\{\{ site_url \}\})/i'=>System::getUrl(),

				);

			$content=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['content']);

			$subject=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['subject']);

			try {
				Mail::send(array(
				'toEmail'=>$loadUser['email'],
				'toName'=>$loadUser['firstname'].' '.$loadUser['lastname'],
				'subject'=>$subject,
				'content'=>$content
				));
			} catch (Exception $e) {
				// throw new Exception($e->getMessage());
				Logs::insert(array(
					'content'=>'Failed sent email "'.$subject.'" to '.$loadUser['email']
					));				
			}

			try {
				Mail::send(array(
				'toEmail'=>FastEcommerce::$setting['order_notify_email'],
				'toName'=>FastEcommerce::$setting['store_name'],
				'subject'=>$subject,
				'content'=>$content
				));
			} catch (Exception $e) {
				// throw new Exception($e->getMessage());
				Logs::insert(array(
					'content'=>'Failed sent email "'.$subject.'" to '.FastEcommerce::$setting['order_notify_email']
					));						
			}
		}


	}

	public static function sendOrderConfirmationEmail($orderid)
	{
		if(isset(FastEcommerce::$setting['allow_send_order_notify_to_customer']) || FastEcommerce::$setting['allow_send_order_notify_to_customer']=='yes')
		{

			$loadOrder=Orders::loadCache($orderid);

			if(!isset($loadOrder['id']))
			{
				throw new Exception('Order ID not exists.');
				
			}

			$customerID=$loadOrder['userid'];

			$loadUser=Customers::loadCache($customerID);

			if(!$loadUser)
			{
				throw new Exception('Userid not exists.');
			}

			$orderTemplate=EmailTemplates::getContent('order_confirmation');

			$replaces=array(
				'/(\{\{\w+\}\})/i'=>"{{ $2 }}",
				'/(\{\{ to_day \}\})/i'=>date('M d, Y H:i'),
				'/(\{\{ orderid \}\})/i'=>$loadOrder['id'],
				'/(\{\{ shop_name \}\})/i'=>FastEcommerce::$setting['store_name'],
				'/(\{\{ shipping_firstname \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_lastname \}\})/i'=>$loadOrder['shipping_lastname'],
				'/(\{\{ payment_method \}\})/i'=>$loadOrder['summary']['payment_method'],
				'/(\{\{ shipping_method \}\})/i'=>$loadOrder['summary']['shipping_method'],
				'/(\{\{ shipping_address_street \}\})/i'=>$loadOrder['shipping_address1'].'|'.$loadOrder['shipping_address2'],
				'/(\{\{ shipping_address_city \}\})/i'=>$loadOrder['shipping_city'],
				'/(\{\{ shipping_address_province \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_address_country \}\})/i'=>$loadOrder['shipping_country'],
				'/(\{\{ shipping_address_phone \}\})/i'=>$loadOrder['shipping_phone'],
				'/(\{\{ shipping_address_zip \}\})/i'=>$loadOrder['shipping_postcode'],
				'/(\{\{ order_url \}\})/i'=>$loadOrder['url'],
				'/(\{\{ total_price \}\})/i'=>$loadOrder['totalFormat'],
				'/(\{\{ site_url \}\})/i'=>System::getUrl(),

				);

			$content=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['content']);

			$subject=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['subject']);

			try {
				Mail::send(array(
				'toEmail'=>$loadUser['email'],
				'toName'=>$loadUser['firstname'].' '.$loadUser['lastname'],
				'subject'=>$subject,
				'content'=>$content
				));
			} catch (Exception $e) {
				// throw new Exception($e->getMessage());
				Logs::insert(array(
					'content'=>'Failed sent email "'.$subject.'" to '.$loadUser['email']
					));					
			}
		}

	}

	public static function sendOrderRefundEmail($orderid)
	{
		if(isset(FastEcommerce::$setting['allow_send_order_notify_to_customer']) || FastEcommerce::$setting['allow_send_order_notify_to_customer']=='yes')
		{

			$loadOrder=Orders::loadCache($orderid);

			if(!isset($loadOrder['id']))
			{
				throw new Exception('Order ID not exists.');
				
			}

			$customerID=$loadOrder['userid'];

			$loadUser=Customers::loadCache($customerID);

			if(!$loadUser)
			{
				throw new Exception('Userid not exists.');
			}

			$orderTemplate=EmailTemplates::getContent('order_refund');

			$replaces=array(
				'/(\{\{\w+\}\})/i'=>"{{ $2 }}",
				'/(\{\{ to_day \}\})/i'=>date('M d, Y H:i'),
				'/(\{\{ orderid \}\})/i'=>$loadOrder['id'],
				'/(\{\{ shop_name \}\})/i'=>FastEcommerce::$setting['store_name'],
				'/(\{\{ shipping_firstname \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_lastname \}\})/i'=>$loadOrder['shipping_lastname'],
				'/(\{\{ payment_method \}\})/i'=>$loadOrder['summary']['payment_method'],
				'/(\{\{ shipping_method \}\})/i'=>$loadOrder['summary']['shipping_method'],
				'/(\{\{ shipping_address_street \}\})/i'=>$loadOrder['shipping_address1'].'|'.$loadOrder['shipping_address2'],
				'/(\{\{ shipping_address_city \}\})/i'=>$loadOrder['shipping_city'],
				'/(\{\{ shipping_address_province \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_address_country \}\})/i'=>$loadOrder['shipping_country'],
				'/(\{\{ shipping_address_phone \}\})/i'=>$loadOrder['shipping_phone'],
				'/(\{\{ shipping_address_zip \}\})/i'=>$loadOrder['shipping_postcode'],
				'/(\{\{ order_url \}\})/i'=>$loadOrder['url'],
				'/(\{\{ total_price \}\})/i'=>$loadOrder['totalFormat'],
				'/(\{\{ site_url \}\})/i'=>System::getUrl(),

				);

			$content=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['content']);

			$subject=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['subject']);

			try {
				Mail::send(array(
				'toEmail'=>$loadUser['email'],
				'toName'=>$loadUser['firstname'].' '.$loadUser['lastname'],
				'subject'=>$subject,
				'content'=>$content
				));
			} catch (Exception $e) {
				// throw new Exception($e->getMessage());
				Logs::insert(array(
					'content'=>'Failed sent email "'.$subject.'" to '.$loadUser['email']
					));					
			}
		}

	}

	public static function sendShippingConfirmationEmail($orderid)
	{
		if(isset(FastEcommerce::$setting['allow_send_order_notify_to_customer']) || FastEcommerce::$setting['allow_send_order_notify_to_customer']=='yes')
		{

			$loadOrder=Orders::loadCache($orderid);

			if(!isset($loadOrder['id']))
			{
				throw new Exception('Order ID not exists.');
				
			}

			$customerID=$loadOrder['userid'];

			$loadUser=Customers::loadCache($customerID);

			if(!$loadUser)
			{
				throw new Exception('Userid not exists.');
			}

			$orderTemplate=EmailTemplates::getContent('shipping_confirmation');

			$replaces=array(
				'/(\{\{\w+\}\})/i'=>"{{ $2 }}",
				'/(\{\{ to_day \}\})/i'=>date('M d, Y H:i'),
				'/(\{\{ orderid \}\})/i'=>$loadOrder['id'],
				'/(\{\{ shop_name \}\})/i'=>FastEcommerce::$setting['store_name'],
				'/(\{\{ billing_firstname \}\})/i'=>$loadUser['firstname'],
				'/(\{\{ billing_lastname \}\})/i'=>$loadUser['lastname'],
				'/(\{\{ shipping_firstname \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_lastname \}\})/i'=>$loadOrder['shipping_lastname'],
				'/(\{\{ payment_method \}\})/i'=>$loadOrder['summary']['payment_method'],
				'/(\{\{ shipping_method \}\})/i'=>$loadOrder['summary']['shipping_method'],
				'/(\{\{ shipping_address_street \}\})/i'=>$loadOrder['shipping_address1'].'|'.$loadOrder['shipping_address2'],
				'/(\{\{ shipping_address_city \}\})/i'=>$loadOrder['shipping_city'],
				'/(\{\{ shipping_address_province \}\})/i'=>$loadOrder['shipping_firstname'],
				'/(\{\{ shipping_address_country \}\})/i'=>$loadOrder['shipping_country'],
				'/(\{\{ shipping_address_phone \}\})/i'=>$loadOrder['shipping_phone'],
				'/(\{\{ shipping_address_zip \}\})/i'=>$loadOrder['shipping_postcode'],
				'/(\{\{ order_url \}\})/i'=>$loadOrder['url'],
				'/(\{\{ total_price \}\})/i'=>$loadOrder['totalFormat'],
				'/(\{\{ tracking_url \}\})/i'=>$loadOrder['shipping_url'],
				'/(\{\{ site_url \}\})/i'=>System::getUrl(),

				);

			$content=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['content']);

			$subject=preg_replace(array_keys($replaces), array_values($replaces), $orderTemplate['subject']);

			try {
				Mail::send(array(
				'toEmail'=>$loadUser['email'],
				'toName'=>$loadUser['firstname'].' '.$loadUser['lastname'],
				'subject'=>$subject,
				'content'=>$content
				));
			} catch (Exception $e) {
				// throw new Exception($e->getMessage());
				Logs::insert(array(
					'content'=>'Failed sent email "'.$subject.'" to '.$loadUser['email']
					));					
			}
		}

	}


}