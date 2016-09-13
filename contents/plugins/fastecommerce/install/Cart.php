<?php

/*

$cart=Cart::loadCache($ip);

$cart=array();

	$cart['product']=list products
	$cart['coupon']=coupon info
	$cart['coupon']['code']=coupon code
	$cart['coupon']['percent']=coupon code
	$cart['discount']=discount info
	$cart['vat']=vat
	$cart['tax']=tax
	$cart['shipping_fee']=shipping fee
	$cart['shipping_type']=shipping type (id|title|amount)
	$cart['totalnovat']=total price but no vat
	$cart['totalvat']=total vat
	$cart['total']=total price with vat,coupon,discount
	$cart['total_product']=total product
	$cart['payment_method']='paypal'
	$cart['weight']=1.56kg

*/

class Cart
{
	public static $cartData=array();

	public static function cartPopup($noWrap=false,$template=1)
	{
		$result='';

		$ip=Http::get('ip');

		$loadData=self::loadCache($ip);

		if((int)$loadData['total_product'] > 0)
		{
			$li='';

			$totalProd=$loadData['total_product'];

			$listID=array_keys($loadData['product']);

			for ($i=0; $i < $totalProd; $i++) { 

				if(!isset($listID[$i]))
				{
					continue;
				}

				$prodID=$listID[$i];

				$prodData=$loadData['product'][$prodID];

				$li.='
	              <tr>
	                <td class="col-lg-6 col-md-6 col-sm-6 "><a href="'.$prodData['url'].'">'.$prodData['title'].'</a></td>
	                <td class="col-lg-2 col-md-2 col-sm-2 text-right ">x'.$prodData['quantity'].'</td>
	                <td class="col-lg-3 col-md-3 col-sm-3 text-right">'.FastEcommerce::money_format($prodData['total']).'</td>
	                <td class="col-lg-1 col-md-1 col-sm-1 "><span data-id="'.$prodData['id'].'" class="remove-product glyphicon glyphicon-remove-sign"></span></td>
	              </tr>


				';
			}

			$templateResult='

            <span class="glyphicon glyphicon-shopping-cart cart-icon">&nbsp;</span>
            <span data-template="1" class="cart-total-summary">'.$loadData['total_product'].' item(s) - '.FastEcommerce::money_format($loadData['totalFormat']).'</span>
			';

			if((int)$template==2)
			{
				$templateResult='
	            <span class="cart-icon">&nbsp;</span>
	            <span data-template="2" class="cart-total-summary">'.$loadData['total_product'].' item(s) - '.FastEcommerce::money_format($loadData['totalFormat']).'</span>
				';				
			}
			elseif((int)$template==3)
			{
				$templateResult='
	            <span class="cart-icon">&nbsp;</span>
	            <span data-template="3" class="cart-total-summary">'.$loadData['total_product'].' item(s)</span>
				';				
			}
			elseif((int)$template==4)
			{
				$templateResult='
	            <span class="cart-icon">&nbsp;</span>
	            <span data-template="4" class="cart-total-summary">'.$loadData['total_product'].'</span>
				';				
			}

			$result='
	          <!-- cart popup -->
	          <div class="cart-popup">
	            '.$templateResult.'

	            <div class="details-popup" style="padding-top:20px;">
	            <div class="list-products">
	              <table class="table ">
	                <tbody>
	                  '.$li.'
	                </tbody>
	              </table>              
	            </div>
	            <div class="cart-summary">
	              <table class="table ">
	                <tbody>
	                  <tr>
	                    <td class="col-lg-7 col-md-7 col-sm-7 text-right"><strong>Sub total</strong></td>
	                    <td class="col-lg-5 col-md-5 col-sm-5 text-right">'.$loadData['totalnovatFormat'].'</td>
	                  </tr>
	                  <tr>
	                    <td class="col-lg-7 col-md-7 col-sm-7 text-right"><strong>VAT ('.FastEcommerce::$setting['default_vat'].'%)</strong></td>
	                    <td class="col-lg-5 col-md-5 col-sm-5 text-right">'.$loadData['totalvatFormat'].'</td>
	                  </tr>
	                  <tr>
	                    <td class="col-lg-7 col-md-7 col-sm-7 text-right"><strong>Tax</strong></td>
	                    <td class="col-lg-5 col-md-5 col-sm-5 text-right">'.$loadData['taxFormat'].'</td>
	                  </tr>
	                  <tr>
	                    <td class="col-lg-7 col-md-7 col-sm-7 text-right"><strong>Total</strong></td>
	                    <td class="col-lg-5 col-md-5 col-sm-5 text-right">'.$loadData['totalFormat'].'</td>
	                  </tr>
	                </tbody>
	              </table>                
	            </div>
	            <div class="cart-popup-footer">
	              <a href="'.System::getUrl().'cart"><span class="glyphicon glyphicon-shopping-cart"></span> View cart</a>
	              <a href="'.System::getUrl().'checkout"><span class="glyphicon glyphicon-random"></span> Checkout</a>
	            </div>


	            </div>
	          </div>
	          <!-- cart popup -->
			';
		}
		else
		{
			$templateResult='
	        <span class="glyphicon glyphicon-shopping-cart cart-icon">&nbsp;</span>
            <span data-template="1" class="cart-total-summary">0 item(s) - '.FastEcommerce::money_format(0).'</span>
			';

			if((int)$template==2)
			{
				$templateResult='
	            <span class="cart-icon">&nbsp;</span>
	            <span data-template="2" class="cart-total-summary">0 item(s) - '.FastEcommerce::money_format(0).'</span>
				';				
			}
			elseif((int)$template==3)
			{
				$templateResult='
	            <span class="cart-icon">&nbsp;</span>
	            <span data-template="3" class="cart-total-summary">0 item(s)</span>
				';				
			}
			elseif((int)$template==4)
			{
				$templateResult='
	            <span class="cart-icon">&nbsp;</span>
	            <span data-template="4" class="cart-total-summary">0</span>
				';				
			}		
				
			$result='
          <!-- cart popup -->
          <div class="cart-popup">
            '.$templateResult.'

            <div class="details-popup">
            <div class="list-products">
              <span style="margin-left:15px;">Empty cart</span>              
            </div>
            </div>
          </div>
          <!-- cart popup -->

			';
		}

		if($noWrap==false)
		{
			$result='<div class="wrap-cart-popup">'.$result.'</div>';
		}

		return $result;
	}

	public static function productExists($prodID=0)
	{
		$result=false;

		if(isset(self::$cartData['product'][$prodID]))
		{
			$result=self::$cartData['product'][$prodID];
		}

		return $result;
	}

	public static function totalItems()
	{
		$total=isset(self::$cartData['total_product'])?self::$cartData['total_product']:0;

		return $total;
	}

	public static function remove($productid=0)
	{
		$ip=Http::get('ip');

		$loadCart=self::loadCache($ip);

		if(isset($loadCart['product'][$productid]))
		{

			unset($loadCart['product'][$productid]);

			$vat=isset(FastEcommerce::$setting['default_vat'])?FastEcommerce::$setting['default_vat']:1;

			$loadCart['vat']=$vat;

			$loadCart['total_product']=count($loadCart['product']);

			$listID=array_keys($loadCart['product']);

			$loadCart['totalnovat']=0;

			$loadCart['totalvat']=0;

			$loadCart['totalusecoupon']=0;

			$loadCart['total']=0;

			$loadCart['weight']=0;

			for ($i=0; $i < $loadCart['total_product']; $i++) { 
				if(!isset($listID[$i]))
				{
					continue;
				}

				$theID=$listID[$i];

				$loadCart['totalnovat']=(double)$loadCart['totalnovat']+((double)$loadCart['product'][$theID]['price']*(int)$loadCart['product'][$theID]['quantity']);

				$loadCart['weight']=(double)$loadCart['weight']+(double)$loadCart['product'][$theID]['weight'];
			}
			

			// Cal Coupon
			if(isset($loadCart['coupon']['code']) && $loadCart['coupon']['code']!='')
			{
				switch ($loadCart['coupon']['type']) {
					case 'percent':
						$loadCart['totalusecoupon']=(double)$loadCart['totalnovat']*((double)$loadCart['coupon']['amount']/100);

						$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
						break;
					case 'fixed':
						$loadCart['totalusecoupon']=(double)$loadCart['coupon']['amount'];

						$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
						break;
					
				}
			}

			$loadCart['totalvat']=((double)$loadCart['totalnovat']*(double)$vat)/100;

			$loadCart['total']=(double)$loadCart['totalnovat']+(double)$loadCart['tax']+(double)$loadCart['shipping_fee']+(double)$loadCart['totalvat'];

			self::saveCache($ip,$loadCart);
		}
	}


	public static function update($productid=0,$quantity=1,$attrData='')
	{
		/*

		$attrData='Size: M,Color: Black'		

		*/

		if((int)$quantity <= 0)
		{
			throw new Exception('Quantity not valid.');
		}

		$loadData=Products::loadCache($productid);

		if(!$loadData)
		{
			throw new Exception('This product not exists in our system.');
		}

		$ip=Http::get('ip');

		$loadCart=self::loadCache($ip);

		$loadCart=!$loadCart?array():$loadCart;

		if(!isset($loadCart['product'][$productid]))
		{
			throw new Exception('This product not exists in your shopping cart.');
		}

		if((int)$quantity<(int)$loadData['require_minimum'])
		{
			$loadCart['product'][$productid]['quantity']=$loadData['require_minimum'];
		}
		else
		{
			$loadCart['product'][$productid]['quantity']=$quantity;
		}

		// $loadCart['product'][$productid]['quantity']=$quantity;

		$vat=isset(FastEcommerce::$setting['default_vat'])?FastEcommerce::$setting['default_vat']:1;

		$loadCart['vat']=$vat;

		$loadCart['total_product']=count($loadCart['product']);

		$listID=array_keys($loadCart['product']);

		$loadCart['totalnovat']=0;

		$loadCart['totalvat']=0;

		$loadCart['totalusecoupon']=0;

		$loadCart['total']=0;

		$loadCart['weight']=0;

		for ($i=0; $i < $loadCart['total_product']; $i++) { 
			if(!isset($listID[$i]))
			{
				continue;
			}

			$theID=$listID[$i];

			$loadCart['product'][$theID]['total']=((double)$loadCart['product'][$theID]['sale_price']*(int)$loadCart['product'][$theID]['quantity']);
			
			$loadCart['product'][$theID]['totalFormat']=FastEcommerce::money_format($loadCart['product'][$theID]['total']);
			
			if(isset($attrData[5]))
			{
				$loadCart['product'][$theID]['attr']=$attrData;
			}

			$loadCart['totalnovat']=(double)$loadCart['totalnovat']+(double)$loadCart['product'][$theID]['total'];

			$loadCart['weight']=(double)$loadCart['weight']+(double)$loadCart['product'][$theID]['weight'];

		}
		

		// Cal Coupon
		if(isset($loadCart['coupon']['code']) && $loadCart['coupon']['code']!='')
		{
			switch ($loadCart['coupon']['type']) {
				case 'percent':
					$loadCart['totalusecoupon']=(double)$loadCart['totalnovat']*((double)$loadCart['coupon']['amount']/100);

					$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
					break;
				case 'fixed':
					$loadCart['totalusecoupon']=(double)$loadCart['coupon']['amount'];

					$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
					break;
				
			}
		}

		$loadCart['totalvat']=((double)$loadCart['totalnovat']*(double)$vat)/100;

		$loadCart['total']=(double)$loadCart['totalnovat']+(double)$loadCart['tax']+(double)$loadCart['shipping_fee']+(double)$loadCart['totalvat'];

		self::saveCache($ip,$loadCart);
	}


	public static function add($productid=0,$quantity=1,$attrData='')
	{
		/*

		$attrData='Size: M\r\nColor: Black\r\nColor: Black'		

		*/

		if((int)$quantity <= 0)
		{
			throw new Exception('Quantity not valid.');
		}

		$prodData=Products::get(array(
			'cache'=>'no',
			'where'=>"where id='$productid'"
			));

		$loadData=isset($prodData[0]['id'])?$prodData[0]:false;

		if(!$loadData)
		{
			throw new Exception('This product not exists in our system.');
		}

		$ip=Http::get('ip');

		$loadCart=self::loadCache($ip);

		$loadCart=!$loadCart?array():$loadCart;

		if(!isset($loadCart['product'][$productid]))
		{
			$loadCart['product'][$productid]=array();
		}

		$totalProd=count($loadCart['product']);

		if($totalProd==1)
		{
			$loadCart['totalnovat']=0;

			$loadCart['weight']=0;

			$loadCart['totalvat']=0;

			$loadCart['total']=0;

			$loadCart['totalusecoupon']=0;

			$loadCart['total_product']=0;

			$loadCart['tax']=0;

			$loadCart['shipping_fee']=0;

			$loadCart['totalnovatFormat']=0;

			$loadCart['totalusecouponFormat']=0;

			$loadCart['weightFormat']=0;

			$loadCart['totalvatFormat']=0;

			$loadCart['totalFormat']=0;

			$loadCart['total_productFormat']=0;			

			$loadCart['taxFormat']=0;

			$loadCart['shipping_feeFormat']=0;


		}

		if((int)$quantity<(int)$loadData['require_minimum'])
		{
			$loadCart['product'][$productid]['quantity']=$loadData['require_minimum'];
		}
		else
		{
			$loadCart['product'][$productid]['quantity']=$quantity;
		}

		$loadCart['product'][$productid]['id']=$loadData['id'];
		$loadCart['product'][$productid]['price']=$loadData['sale_price'];
		$loadCart['product'][$productid]['priceFormat']=FastEcommerce::money_format($loadData['sale_price']);
		$loadCart['product'][$productid]['title']=$loadData['title'];
		$loadCart['product'][$productid]['require_minimum']=$loadData['require_minimum'];
		$loadCart['product'][$productid]['imageUrl']=$loadData['imageUrl'];
		$loadCart['product'][$productid]['url']=$loadData['url'];
		$loadCart['product'][$productid]['weight']=$loadData['weight'];
		$loadCart['product'][$productid]['attr']=$attrData;

		$loadCart['product'][$productid]['total']=(double)$loadData['sale_price']*(int)$loadCart['product'][$productid]['quantity'];
		$loadCart['product'][$productid]['totalFormat']=FastEcommerce::money_format($loadCart['product'][$productid]['total']);

		$vat=isset(FastEcommerce::$setting['default_vat'])?FastEcommerce::$setting['default_vat']:1;

		$loadCart['vat']=$vat;

		$totalnovat=isset($loadCart['totalnovat'])?$loadCart['totalnovat']:0;

		$total=isset($loadCart['total'])?$loadCart['total']:0;

		$loadCart['totalnovat']=(double)$totalnovat+(double)$loadCart['product'][$productid]['total'];

		// Cal Coupon
		if(isset($loadCart['coupon']['code']) && $loadCart['coupon']['code']!='')
		{
			switch ($loadCart['coupon']['type']) {
				case 'percent':
					$loadCart['totalusecoupon']=(double)$loadCart['totalnovat']*((double)$loadCart['coupon']['amount']/100);

					$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
					break;
				case 'fixed':
					$loadCart['totalusecoupon']=(double)$loadCart['coupon']['amount'];

					$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
					break;
				
			}
		}

		$loadCart['weight']=(double)$loadCart['weight']+(double)$loadCart['product'][$productid]['weight'];

		$loadCart['totalvat']=((double)$loadCart['totalnovat']*(double)$vat)/100;


		$loadCart['total']=(double)$loadCart['totalnovat']+(double)$loadCart['tax']+(double)$loadCart['shipping_fee']+(double)$loadCart['totalvat'];

		$loadCart['total_product']=count($loadCart['product']);

		$loadCart['payment_method']=isset($loadCart['payment_method'])?$loadCart['payment_method']:'paypal';

		self::saveCache($ip,$loadCart);
	}

	public static function addPayment($ip='',$paymentMethod='paypal')
	{

		$loadCart=self::loadCache($ip);

		if(!$loadCart)
		{
			return false;
		}

		self::saveCache($ip,$loadCart);
	}

	public static function addCoupon($code='')
	{
		if($code=='')
		{
			throw new Exception('Coupon code not valid.');
			
		}

		$loadData=Coupons::loadCache($code);

		if(!$loadData)
		{
			throw new Exception('Coupon code not valid.');
			
		}

		if((int)$loadData['status']==0)
		{
			throw new Exception('This coupon code not activate.');
			
		}

		if(isset(self::$cartData['coupon']['code']) && self::$cartData['coupon']['code']!='')
		{
			throw new Exception('You can not use multiple coupon.');
			
		}

		$ip=Http::get('ip');

		$curTime=time();

		$couponTimeStart=strtotime($loadData['date_start']);

		$couponTimeEnd=strtotime($loadData['date_end']);



		if((int)$curTime>=(int)$couponTimeStart && (int)$curTime<=(int)$couponTimeEnd)
		{
			self::$cartData['coupon']['type']=$loadData['type'];

			self::$cartData['coupon']['code']=$loadData['code'];

			self::$cartData['coupon']['amount']=$loadData['amount'];

			self::saveCache($ip,self::$cartData);

			self::refresh();

		}
		else
		{
			throw new Exception('Coupon code not valid.');
		}


	}

	public static function loadCache($ip='')
	{
		self::$cartData=array(
			'product'=>array(),
			'weight'=>0,
			'total'=>0,
			'totalvat'=>0,
			'tax'=>0,
			'shipping_fee'=>0,
			'shipping_type'=>'',
			'totalnovat'=>0,
			'totalusecoupon'=>0,
			'total_product'=>0,
			'totalFormat'=>FastEcommerce::money_format(0),
			'totalnovatFormat'=>FastEcommerce::money_format(0),
			'totalvatFormat'=>FastEcommerce::money_format(0),
			'vat'=>0,
			'vatFormat'=>FastEcommerce::money_format(0),
			'payment_method'=>'paypal',
			'coupon'=>array(),
			'discount'=>array()
			);

		$hashMd5=md5($ip);

		$today=date('Y-m-d');

		$savePath=ROOT_PATH.'contents/fastecommerce/cart/'.$today.'/'.$hashMd5.'.cache';

		if(!file_exists($savePath))
		{
			return self::$cartData;
		}

		$loadData=unserialize(file_get_contents($savePath));

		self::$cartData=$loadData;

		return $loadData;
	}

	public static function removeCache($ip='')
	{
		$hashMd5=md5($ip);

		$savePath=ROOT_PATH.'contents/fastecommerce/cart/'.$today.'/'.$hashMd5.'.cache';

		if(file_exists($savePath))
		{
			unlink($savePath);
		}

	}

	public static function clear()
	{
		$ip=Http::get('ip');

		$inputData=array(
			'product'=>array(),
			'weight'=>0,
			'total'=>0,
			'totalvat'=>0,
			'tax'=>0,
			'taxFormat'=>FastEcommerce::money_format(0),
			'shipping_fee'=>0,
			'shipping_feeFormat'=>FastEcommerce::money_format(0),
			'shipping_type'=>'',
			'totalnovat'=>0,
			'totalusecoupon'=>0,
			'total_product'=>0,
			'totalFormat'=>FastEcommerce::money_format(0),
			'totalnovatFormat'=>FastEcommerce::money_format(0),
			'totalvatFormat'=>FastEcommerce::money_format(0),
			'vat'=>0,
			'vatFormat'=>FastEcommerce::money_format(0),
			'payment_method'=>'paypal',
			'coupon'=>array('type'=>'','code'=>'','amount'=>0),
			'discount'=>array()
			);

		$hashMd5=md5($ip);

		$today=date('Y-m-d');

		$savePath=ROOT_PATH.'contents/fastecommerce/cart/'.$today.'/'.$hashMd5.'.cache';

		File::create($savePath,serialize($inputData));			
	}

	public static function refresh()
	{
		$ip=Http::get('ip');

		$loadCart=self::loadCache($ip);

		$vat=isset(FastEcommerce::$setting['default_vat'])?FastEcommerce::$setting['default_vat']:1;

		$loadCart['vat']=$vat;

		$loadCart['total_product']=count($loadCart['product']);

		$listID=array_keys($loadCart['product']);

		$loadCart['totalnovat']=0;

		$loadCart['totalvat']=0;

		$loadCart['totalusecoupon']=0;

		$loadCart['total']=0;

		$loadCart['weight']=0;

		for ($i=0; $i < $loadCart['total_product']; $i++) { 
			if(!isset($listID[$i]))
			{
				continue;
			}

			$theID=$listID[$i];

			$loadCart['product'][$theID]['total']=((double)$loadCart['product'][$theID]['price']*(int)$loadCart['product'][$theID]['quantity']);
			
			$loadCart['product'][$theID]['totalFormat']=FastEcommerce::money_format($loadCart['product'][$theID]['total']);

			$loadCart['totalnovat']=(double)$loadCart['totalnovat']+(double)$loadCart['product'][$theID]['total'];

			$loadCart['weight']=(double)$loadCart['weight']+(double)$loadCart['product'][$theID]['weight'];

		}
		

		// Cal Coupon
		if(isset($loadCart['coupon']['code']) && $loadCart['coupon']['code']!='')
		{
			switch ($loadCart['coupon']['type']) {
				case 'percent':
					$loadCart['totalusecoupon']=(double)$loadCart['totalnovat']*((double)$loadCart['coupon']['amount']/100);

					$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
					break;
				case 'fixed':
					$loadCart['totalusecoupon']=(double)$loadCart['coupon']['amount'];

					$loadCart['totalnovat']=(double)$loadCart['totalnovat']-(double)$loadCart['totalusecoupon'];
					break;
				
			}
		}

		$loadCart['totalvat']=((double)$loadCart['totalnovat']*(double)$vat)/100;

		$loadCart['total']=(double)$loadCart['totalnovat']+(double)$loadCart['tax']+(double)$loadCart['shipping_fee']+(double)$loadCart['totalvat'];

		self::$cartData=$loadCart;

		self::saveCache($ip,$loadCart);		
	}

	public static function saveCache($ip,$inputData=array())
	{
		self::$cartData=$inputData;

		$hashMd5=md5($ip);

		$today=date('Y-m-d');

		$inputData['totalFormat']=FastEcommerce::money_format($inputData['total']);

		$inputData['totalnovatFormat']=FastEcommerce::money_format($inputData['totalnovat']);

		$inputData['totalvatFormat']=FastEcommerce::money_format($inputData['totalvat']);

		$inputData['totalusecouponFormat']=FastEcommerce::money_format($inputData['totalusecoupon']);

		$inputData['vatFormat']=FastEcommerce::money_format($inputData['vat']);

		$inputData['shipping_feeFormat']=FastEcommerce::money_format($inputData['shipping_fee']);

		$inputData['taxFormat']=FastEcommerce::money_format($inputData['tax']);

		$inputData=serialize($inputData);

		$savePath=ROOT_PATH.'contents/fastecommerce/cart/'.$today.'/'.$hashMd5.'.cache';

		File::create($savePath,$inputData);
	}
}