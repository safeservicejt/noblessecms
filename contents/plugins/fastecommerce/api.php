<?php

// http://site.com/api/plugin/fastecommerce/get_list_category

class SelfApi
{
	public static function route()
	{
		$listRoute=array(
            'update_on_cart'=>'updateOnCart',
            'remove_on_cart'=>'removeOnCart',
            'add_to_cart'=>'addToCart',
            'get_cart_content'=>'getCartContent',
            'get_cart_popup_content'=>'getCartPopupContent',
            'get_update_tax'=>'getUpdateTax',
            'get_update_shipping_rate'=>'getUpdateShippingRate',
            'confirm_order'=>'confirmOrder',
            'get_withdraw_details'=>'getWithdrawDetails',
            'add_to_wish_list'=>'addToWishList',
            'get_admincp_lang'=>'getAdmincpLang',
            'get_customer_lang'=>'getCustomerLang',
            'get_frontend_lang'=>'getFrontEndLang',
            'get_list_category'=>'listCategory',
            'create_collection_url'=>'createCollectionUrl',
            'send_email'=>'sendEmail',
            'get_email_list_marketing'=>'getEmaiListMarketing',
            'download_in_order'=>'downloadInOrder',
            'add_email_newsletter'=>'addEmailNewsletter',
            'get_product_autocomplete_by_title'=>'getProductAutocompleteByTitle',
			);

		return $listRoute;
	}

    public static function addEmailNewsletter()
    {
        $send_email=trim(Request::get('send_email',''));

        if($send_email=='' || !preg_match('/^[a-z0-9A-Z_\-\.]+\@[a-z0-9A-Z_\.\-]+$/i', $send_email))
        {
            throw new Exception('Email not valid.');
            
        }

        $loadData=NewsLetter::get(array(
            'cache'=>'no',
            'where'=>"where email='$send_email'"
            ));

        if(isset($loadData[0]['email']))
        {
            throw new Exception('This email have been exists added.');
        }
        else
        {
            NewsLetter::insert(array(
                'email'=>$send_email
                ));            
        }

    }

    public static function downloadInOrder()
    {
        if(!$match=Uri::match('download_in_order\/([a-z0-9A-Z_\-\+\=]+)$'))
        {
            Alert::make('Page not found');
        }

        $hash=$match[1];

        $data=String::decrypt(base64_decode($hash));

        $parse=explode(':', $data);

        $userid=(int)$parse[0];

        $orderid=$parse[1];

        $productid=(int)$parse[2];

        $filePath=$parse[3];

        $orderData=Orders::loadCache($orderid);

        if(!$orderData)
        {
            Alert::make('File not found.');
        }

        if((int)$orderData['userid']!=$userid)
        {
            Alert::make('You not have permission to download this file.');
        }

        if(!isset($orderData['products'][$productid]))
        {
            Alert::make('Data not valid.');
        }

        // $filePath=ROOT_PATH.$filePath;

        // echo $filePath;die();
        // if(!file_exists($filePath))
        // {
        //     Alert::make('File not exists.');
        // }

        File::download($filePath);

        die();
    }

    public static function getEmaiListMarketing()
    {
        $owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

        $userid=Users::getCookieUserId();

        if($owner!='yes')
        {
            throw new Exception('You not have permission to send email.');
            
        }
                
        $send_list_group=Request::get('send_list_group','newsletter');

        $result=array();

        switch ($send_list_group) {
            case 'newsletter':
            
                $result=NewsLetter::get(array(
                    'cache'=>'no'
                    ));

                break;

            case 'customers':

                $result=Users::get(array(
                    'selectFields'=>'email,userid',
                    'cache'=>'no'
                    ));

                break;
        
        }

        $emailList=array();

        $total=count($result);

        for ($i=0; $i < $total; $i++) { 

            if(!isset($result[$i]['email']))
            {
                continue;
            }

            $emailList[]=$result[$i]['email'];
        }

        return $emailList;
    }

    public static function sendEmail()
    {
        $owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

        $userid=Users::getCookieUserId();

        if($owner!='yes')
        {
            throw new Exception('You not have permission to send email.');
            
        }

        $send_subject=Request::get('send_subject','');

        $send_content=Request::get('send_content','');

        $send_email=Request::get('send_email','');

        if($send_subject=='' || $send_content=='' || $send_email=='')
        {
            throw new Exception('Data not valid.');
            
        }

        Mail::send(array(
        'toEmail'=>$send_email,
        'toName'=>'You',
        'subject'=>$send_subject,
        'content'=>$send_content     

        ));        

    }

    public static function createCollectionUrl()
    {
        $urls=Request::get('send_urls','');

        if(!preg_match_all('/\-(\d+)\.html/i', $urls, $matches))
        {
            throw new Exception('Data not valid.');
            
        }

        $userid=Users::getCookieUserId();

        $listID="'".implode("','", $matches[1])."'";

        $colHas=CollectionsProducts::saveCache($userid,$listID);        

        $result=CollectionsProducts::url($colHas);

        return $result;

    }

    public static function getProductAutocompleteByTitle()
    {
        $title=Request::get('send_title','');

        if(!isset($title[1]))
        {
            throw new Exception('Data not valid.');
        } 

        $loadData=Products::get(array(
            'cache'=>'yes',
            'cacheTime'=>60,
            'where'=>"where title LIKE '%".addslashes($title)."%'"
            ));

        return $loadData;
    }

    public static function getWithdrawDetails()
    {
        $id=Request::get('send_id',0); 
        
        $userid=Request::get('send_userid',0); 

        $loadData=AffiliatesWithdraws::get(array(
            'cache'=>'no',
            'where'=>"where id='$id' AND userid='$userid'"
            ));

        if(!isset($loadData[0]['id']))
        {
            throw new Exception('Data not valid.');
            
        }

        $userData=Customers::loadCache($userid);

        $result=array();

        $result['total_money_request']=$loadData[0]['money'];

        $result['total_money_requestFormat']=FastEcommerce::money_format($loadData[0]['money']);

        $result['payment_details']=$userData['withdraw_summary'];

        return $result;

    }

    public static function getFrontEndLang()
    {
        $result=array();

        $result=Lang::get('home');  
        
        return json_encode($result);  
    }

    public static function getAdmincpLang()
    {
        $result=array();

        $result=Lang::get('admincp/index');  
        
        return json_encode($result);  
    }

    public static function getCustomerLang()
    {
        $result=array();

        $result=Lang::get('usercp/index');  
        
        return json_encode($result);  
    }

    public static function addToWishList()
    {
        $userid=(int)Users::getCookieUserId();

        if($userid==0)
        {
            
        }

        $send_id=(int)trim(Request::get('send_id',0));

        if($send_id==0)
        {
            throw new Exception('Data not valid.');
            
        }

        $loadProd=Products::loadCache($send_id);

        if(!$loadProd)
        {
            throw new Exception('This product not exists in our system.');
        }

        WishList::insert(array(
            'productid'=>$send_id,
            'productid'=>$send_id,
            ));

    }

    public static function setCancelOrder()
    {

    }

    public static function confirmOrder()
    {
        // $send_data->shipping_country

        $result=array();

        $send_data=trim(Request::get('send_data',false));


        if($send_data==false)
        {
            throw new Exception('Data not valid.');
            
        }

        $send_data=json_decode($send_data);

        $userid=Users::getCookieUserId();

        $shipping_same=$send_data->shipping_same;

        $shipping_class=$send_data->shipping_method;

        $payment_method=$send_data->payment_method;

        $paymentMethodData=Payments::loadCache($payment_method);

        if(!$paymentMethodData)
        {
            throw new Exception('Payment method not valid.');
            
        }

        $shippingRateData=ShippingRates::loadCache($shipping_class);


        if(!$shippingRateData)
        {
            throw new Exception('Shipping method not valid.');
        }        

        // If is new user && not logined
        if(!$userid || (int)$userid==0)
        {

            // Check valid email
            if(!isset($send_data->email[5]) || !preg_match('/^[a-z0-9A-Z_\.\-]+\@\w+\.\w+/i', $send_data->email))
            {
                throw new Exception('Your email not valid');
                
            }

            if(!isset($send_data->email[1]))
            {
                throw new Exception('Your email address not valid.');
            }

            $userEmail=addslashes($send_data->email);

            $userData=Users::get(array(
                'cache'=>'no',
                'where'=>"where email='$userEmail'"
                ));

            if(isset($userData[0]['userid']))
            {
                throw new Exception('Your email have been exists in our system. You can login!');
            }

            $newUsername=String::randNumber(8);

            $newPassword=String::randText(6);

            $insertUser=array(
                'email'=>addslashes($send_data->email),
                'username'=>$newUsername,
                'password'=>$newPassword,
                'firstname'=>addslashes($send_data->billing_firstname),
                'lastname'=>addslashes($send_data->billing_lastname),
                'address_1'=>addslashes($send_data->billing_address1),
                'address_2'=>addslashes($send_data->billing_address2),
                'city'=>addslashes($send_data->billing_city),
                'postcode'=>addslashes($send_data->billing_postcode),
                'state'=>addslashes($send_data->billing_state),
                'country'=>addslashes($send_data->billing_country),
                'phone'=>addslashes($send_data->billing_phone),
                );

            try {
                $userid=Users::makeRegister($insertUser);

                Customers::insert(array(
                    'userid'=>$userid,
                    'commission'=>FastEcommerce::$setting['affiliate_percent'],
                    ));

                Customers::saveCache($userid);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }


        // if(!isset($send_data->shipping_firstname[1]) || !isset($send_data->shipping_lastname[1]) || !isset($send_data->shipping_address1[1]) || !isset($send_data->shipping_city[1]) || !isset($send_data->shipping_postcode[1]) || !isset($send_data->shipping_country[1]) || !isset($send_data->shipping_phone[1]))
        // {
        //     throw new Exception('Your shipping information not valid.');
        // }

        // Load cart information

        $ip=Http::get('ip');

        $loadCart=Cart::loadCache($ip);  

        if(!isset($loadCart['product']))
        {
            throw new Exception('Your shopping cart is empty.');
            
        }
        
        $listProdID=array_keys($loadCart['product']);      

        $orderData=array();

        $orderData['userid']=$userid;

        if($shipping_same!='yes')
        {
            $orderData['shipping_firstname']=$send_data->shipping_firstname;
            $orderData['shipping_lastname']=$send_data->shipping_lastname;
            $orderData['shipping_phone']=$send_data->shipping_phone;
            $orderData['shipping_company']=$send_data->shipping_company;
            $orderData['shipping_address1']=$send_data->shipping_address1;
            $orderData['shipping_address2']=$send_data->shipping_address2;
            $orderData['shipping_city']=$send_data->shipping_city;
            $orderData['shipping_postcode']=$send_data->shipping_postcode;
            $orderData['shipping_state']=$send_data->shipping_state;
            $orderData['shipping_country']=$send_data->shipping_country_name;            
        }
        else
        {
            $orderData['shipping_firstname']=$send_data->billing_firstname;
            $orderData['shipping_lastname']=$send_data->billing_lastname;
            $orderData['shipping_phone']=$send_data->billing_phone;
            $orderData['shipping_company']=$send_data->billing_company;
            $orderData['shipping_address1']=$send_data->billing_address1;
            $orderData['shipping_address2']=$send_data->billing_address2;
            $orderData['shipping_city']=$send_data->billing_city;
            $orderData['shipping_postcode']=$send_data->billing_postcode;
            $orderData['shipping_state']=$send_data->billing_state;
            $orderData['shipping_country']=$send_data->billing_country_name;             
        }


        $orderData['comment']=$send_data->order_comment;
        $orderData['ip']=$ip;
        $orderData['status']='draft';
        $orderData['products']=$loadCart['product'];
        $orderData['vat']=$loadCart['vat'];
        $orderData['total']=$loadCart['total'];

        $orderData['affiliateid']=Affiliates::getAffiliateID();
        
        $orderData['summary']=array();

        $orderData['summary']['payment_method']=$paymentMethodData['title'];

        $orderData['summary']['totalnovat']=$loadCart['totalnovat'];

        $orderData['summary']['weight']=$loadCart['weight'].' '.FastEcommerce::getWeightUnit();

        $orderData['summary']['vat']=$loadCart['vat'];

        $orderData['summary']['totalvat']=$loadCart['totalvat'];

        $orderData['summary']['total']=$loadCart['total'];

        $orderData['summary']['total_product']=$loadCart['total_product'];

        $orderData['summary']['totalusecoupon']=$loadCart['totalusecoupon'];

        $orderData['summary']['totalFormat']=$loadCart['totalFormat'];

        $orderData['summary']['shipping_fee']=$loadCart['shipping_fee'];

        $orderData['summary']['tax']=$loadCart['tax'];

        $orderData['summary']['shipping_method']=$shippingRateData['title'];

        $orderData['summary']['shipping_amount']=$shippingRateData['amount'];

        $orderData['summary']['cart_product']=$loadCart['product'];

        $orderData['summary']['coupon']='';

        if(isset($loadCart['coupon']['code']) && $loadCart['coupon']['code']!='')
        {
            $orderData['summary']['coupon']=$loadCart['coupon'];
            $orderData['summary']['coupon']['amountFormat']=Coupons::format($loadCart['coupon']['code']);
        }

        $orderData['summary']['country_code']=$send_data->billing_country;  

        if(!$orderid=Orders::insert($orderData))
        {
            throw new Exception('We can not create your order at this time.');
            
        }

        $totalProd=count($listProdID);

        for ($i=0; $i < $totalProd; $i++) { 
            $prodID=$listProdID[$i];

            OrderProducts::insert(array(
                'orderid'=>$orderid,
                'productid'=>$prodID,
                'quantity'=>$loadCart['product'][$prodID]['quantity'],
                'price'=>$loadCart['product'][$prodID]['price'],
                'total'=>$loadCart['product'][$prodID]['total'],
                ));
        }

        Orders::saveCache($orderid);

        // Save order information


        // Load payment method process
        $orderData['orderid']=$orderid;

        $orderData['email']=$send_data->email;

        $orderData['userid']=$userid;

        $response=array();

        try {
            $response=Payments::callProcess($payment_method,'before_confirm_order',$orderData);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if($response['method']=='submit_form')
        {
            $result['submit_form']=$response['data'];
        }
        elseif($response['method']=='redirect')
        {
            $result['redirect']='yes';
            $result['url']=$response['data'];
        }
        elseif($response['method']=='embed')
        {
            $result['embed']='yes';
            $result['html']=$response['data'];
        }

        Cart::clear();

        Affiliates::after_insert_order($orderid);

        Notifies::sendNewOrderEmail($orderid);

        // Return result

        return $result;
    }

    public static function getUpdateShippingRate()
    {
        $send_id=trim(Request::get('send_id',0));

        if((int)$send_id==0)
        {
            throw new Exception('Shipping rate not valid.');
        }

        $ip=Http::get('ip');

        $loadCart=Cart::loadCache($ip);

        $loadShippingRate=ShippingRates::loadCache($send_id);

        if(!isset($loadShippingRate['id']))
        {
            throw new Exception('Shipping rate not exists in our system.');
        }

        $loadCart['shipping_fee']=$loadShippingRate['amount'];

        Cart::saveCache($ip,$loadCart);

        Cart::refresh();

        return $loadCart;        
    }

    public static function getUpdateTax()
    {
        $result=array(
            'shipping_fee'=>0,
            'tax'=>0,
            'total'=>0,
            );

        $ip=Http::get('ip');

        $send_shipping_country=trim(Request::get('send_shipping_country',''));

        $send_billing_country=trim(Request::get('send_billing_country',''));

        $send_issamebilling=trim(Request::get('send_issamebilling','yes'));

        if($send_issamebilling=='yes')
        {
            $send_shipping_country=$send_billing_country;
        }

        $result['tax']=TaxRates::getTax($send_shipping_country);

        $loadCart=Cart::loadCache($ip);

        $loadCart['tax']=$result['tax'];

        Cart::saveCache($ip,$loadCart);

        Cart::refresh();

        $result['total']=$loadCart['total'];

        $result['tax']=FastEcommerce::money_format($result['tax']);
        $result['shipping_fee']=FastEcommerce::money_format($result['shipping_fee']);
        $result['total']=FastEcommerce::money_format($result['total']);

        return $loadCart;

    }

    public static function getCartContent()
    {
        return Cart::$cartData;
    }

    public static function getCartPopupContent()
    {
        $send_template=Request::get('send_template',1);

        return Cart::cartPopup(true,$send_template);
    }

    public static function updateOnCart()
    {
        $send_productid=trim(Request::get('send_productid',0));

        $send_quantity=trim(Request::get('send_quantity',1));

        if((int)$send_productid==0)
        {
            throw new Exception('Data not valid.');
        }

        $loadData=Products::loadCache($send_productid);

        if(!$loadData)
        {
            throw new Exception('Product not exists.');
            
        }

        $isValid=(float)$send_quantity%(float)$loadData['require_minimum'];

        if($isValid!=0)
        {
            throw new Exception('This product require add minimum is '.$loadData['require_minimum'].' into your shopping cart');
        }

        try {
            Cart::update($send_productid,$send_quantity);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            
        }
    }

    public static function removeOnCart()
    {
        $send_productid=trim(Request::get('send_productid',0));

        if((int)$send_productid==0)
        {
            throw new Exception('Data not valid.');
        }

        $valid=Products::exists($send_productid);

        if(!$valid)
        {
            throw new Exception('Product not exists.');
        }

        Cart::remove($send_productid);
    }

    public static function addToCart()
    {

        $send_productid=trim(Request::get('send_productid',0));

        $send_quantity=trim(Request::get('send_quantity',1));

        $send_attr=trim(Request::get('send_attr',''));

        if((int)$send_productid==0)
        {
            throw new Exception('Data not valid.');
        }

        Cart::loadCache(Http::get('ip'));

        if(isset(Cart::$cartData['product'][$send_productid]))
        {
            throw new Exception('This product is exists in your shopping cart');
        }

        $loadData=Products::loadCache($send_productid);

        if(!$loadData)
        {
            throw new Exception('Product not exists.');
        }

        if((int)$send_quantity<(int)$loadData['require_minimum'])
        {
            throw new Exception('This product require add minimum is '.$loadData['require_minimum'].' into your shopping cart');
            
        }


        if(isset($loadData['attr_data']))
        {
            $total=count($loadData['attr_data']);

            if(!isset($send_attr[5]) && $total > 0)
            {
                return array(
                    'redirect'=>'yes',
                    'url'=>$loadData['url']
                    );
            }
        }


        try {
            Cart::add($send_productid,$send_quantity,$send_attr);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            
        }
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
