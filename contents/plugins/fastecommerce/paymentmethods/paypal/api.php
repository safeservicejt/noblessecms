<?php

// http://site.com/paymentapi/paypal/success

class SelfApi
{
	public static function route()
	{
		$listRoute=array(
            'notify'=>'notifyProcess',
            'success'=>'successProcess',
            'error'=>'errorProcess',
            'cancel'=>'cancelProcess',
            'pending'=>'pendingProcess',
            'approved'=>'approvedProcess',
            'completed'=>'completedProcess',
			);

		return $listRoute;
	}

    public static function cancelProcess()
    {
        $orderid=trim(Request::get('custom',0));

        Orders::update($orderid,array(
            'status'=>'canceled'
            ));

        Orders::saveCache($orderid);

        Redirect::to(System::getUrl());

    }

    public static function notifyProcess()
    {
        $orderid=trim(Request::get('custom',0));

        if((int)$orderid > 0)
        {
            $orderData=Orders::loadCache($orderid);

            if(!$orderData)
            {
                throw new Exception('This order not exists in our system');
                
            }

            // if($orderData['status']!='draft')
            // {
            //     throw new Exception('This order have been verified.');
                
            // }

            $request = 'cmd=_notify-validate';

            foreach ($_POST as $key => $value) {
                $request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
            }            

            $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            $order_status='pending';

            if (!$response) {
                throw new Exception('Failed to verify');
                
            }

            if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($_POST['payment_status'])) 
            {
                switch($_POST['payment_status']) {
                    case 'Canceled_Reversal':
                        $order_status='canceled';
                        break;
                    case 'Completed':
                        $order_status='completed';
                        break;
                    case 'Denied':
                        $order_status='canceled';
                        break;
                    case 'Expired':
                        $order_status='canceled';
                        break;
                    case 'Failed':
                        $order_status='canceled';
                        break;
                    case 'Pending':
                        $order_status='pending';
                        break;
                    case 'Processed':
                        $order_status='pending';
                        break;
                    case 'Refunded':
                        $order_status='refund';
                        break;
                    case 'Reversed':
                        $order_status='canceled';
                        break;
                    case 'Voided':
                        $order_status='pending';
                        break;
                }
            }

            curl_close($curl);

            Orders::update($orderid,array(
                'status'=>$order_status
                ));

            Orders::saveCache($orderid);       

            switch ($order_status) {
                     case 'canceled':
                         Notifies::sendOrderCanceledEmail($orderid);  
                         break;
                     case 'completed':
                         Notifies::sendOrderConfirmationEmail($orderid);  
                         break;
                     case 'refund':
                         Notifies::sendOrderRefundEmail($orderid);  
                         break;
                     
                 }     

        }   
        else
        {
            throw new Exception('Data not valid');
            
        }

        Redirect::to(System::getUrl());

    }

	
}
