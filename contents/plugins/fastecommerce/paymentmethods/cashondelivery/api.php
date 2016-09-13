<?php

// http://site.com/paymentapi/paypal/success

class SelfApi
{
	public static function route()
	{
		$listRoute=array(
            'success'=>'successProcess',
            'error'=>'errorProcess',
            'cancel'=>'cancelProcess',
            'pending'=>'pendingProcess',
            'approved'=>'approvedProcess',
            'completed'=>'completedProcess',
			);

		return $listRoute;
	}

    public static function updateProduct()
    {
        $valid=Validator::make(array(
            'send_productid'=>'number|slashes',
            'send_quantity'=>'number|slashes'

            ));

        if(!$valid)
        {
            throw new Exception(Validator::getMessage());
        }

        $productid=trim(Request::get('send_productid'));
        $quantity=trim(Request::get('send_quantity'));

        // Cart::removeProduct($productid);
       

        try {
            Cart::addProduct($productid,$quantity);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

	
}
