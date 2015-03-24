<?php

class Cart
{

	public function isEmpty()
	{
		if(!isset($_SESSION['cart']))
		{
			return true;
		}

		$first=current($_SESSION['cart']);

		if(!$first)
		{
			return true;
		}

		return false;
	}

	public function add($prodid,$quantity=1)
	{
		if((int)$quantity <= 0)
		{
			return false;
		}


		if(!isset($_SESSION['cart']))
		{
			$_SESSION['cart']=array();
		}

		if(isset($_SESSION['cart'][$prodid]))
		{
			$old=$_SESSION['cart'][$prodid];

			$_SESSION['cart'][$prodid]=(int)$old + (int)$quantity;
		}
		else
		{
			$_SESSION['cart'][$prodid]=$quantity;			
		}
	}

	public function has($prodid)
	{
		if(!isset($_SESSION['cart'][$prodid]))
		{
			return false;
		}

		return true;

	}

	public function discountProcess($cartData=array())
	{
		$cartData['discount']=0;		
		
		if(Session::has('discount'))
		{
			// print_r(Session::get('discount.voucher'));die();

			if(isset($_SESSION['discount']['coupon']))
			{
				$coupon=$_SESSION['discount']['coupon'];

				$today=date('Y-m-d');

				$listID="'".implode("','", $coupon)."'";

				$loadData=Coupons::get(array(
					'where'=>"where coupon_code IN ($listID) AND date_end >= '$today'"
					));

				if(isset($loadData[0]['nodeid']))
				{
					$totalCoupon=count($loadData);

					$totalDiscount=0;

					for($i=0;$i<$totalCoupon;$i++)
					{
						switch ($loadData[$i]['coupon_type']) {

							case 'money':

								$cartData['subtotal']=(double)$cartData['subtotal'] - (double)$loadData[$i]['amount'];

								$totalCoupon+=(double)$loadData[$i]['amount'];

								break;

							case 'percent':

								$tmp=((double)$cartData['subtotal'] * (double)$loadData[$i]['amount'])/100;

								$cartData['subtotal']=(double)$cartData['subtotal'] - (double)$tmp;

								$totalCoupon+=(double)$tmp;

								break;
							
						}
					}

					if((double)$cartData['subtotal'] <= 0)
					{
						$cartData['subtotal']=0;
					}

					$cartData['discount']=(double)$cartData['discount']+(double)$totalCoupon;
				}

			}


			if(isset($_SESSION['discount']['voucher']))
			{

				$voucher=$_SESSION['discount']['voucher'];

				$totalVoucher=count($voucher);

				$totalDiscount=0;

				for($i=0;$i<$totalVoucher;$i++)
				{
					$theVoucher=$_SESSION['discount']['voucher'][$i];

					$cartData['subtotal']=(double)$cartData['subtotal'] - (double)$theVoucher['balance'];

					if((double)$cartData['subtotal'] <= 0)
					{
						$cartData['subtotal']=0;

						$_SESSION['discount']['voucher'][$i]['balance']=(double)$theVoucher['balance']-(double)$cartData['subtotal'];

						$totalDiscount+=(double)$_SESSION['discount']['voucher'][$i]['balance'];		

						break;
					}
					else
					{
						$totalDiscount+=(double)$theVoucher['balance'];						
					}						
				}
				
				$cartData['discount']+=(double)$totalDiscount;

			}

			// $cartData['discount']=Currency::insertPrice($cartData['discount']);

		}



		return $cartData;
	}

	public function remove($prodid)
	{
		if(isset($_SESSION['cart'][$prodid]))
		unset($_SESSION['cart'][$prodid]);
	}

	public function data()
	{
		if(!isset($_SESSION['cart']))
		{
			return false;
		}
		
		$resultData=array();

		$totalItem=count($_SESSION['cart']);

		if((int)$totalItem==0)
		{

			return $resultData;
		}

		$listID=array_keys($_SESSION['cart']);

		$parseID="'".implode("','",$listID)."'";

		$resultData=Products::get(array(
			'selectFields'=>'productid,title,image,price,friendly_url,date_discount,date_enddiscount,price_discount,quantity_discount',
			'where'=>"where productid in ($parseID)"
			));

		return $resultData;
	}

	public function clear()
	{
		unset($_SESSION['cart']);

		$_SESSION['cart']=array();
	}


	public function theVAT()
	{
		$vat=1;

		if(isset(GlobalCMS::$setting['default_vat_commission']))
		{
			$vat=GlobalCMS::$setting['default_vat_commission'];

			// $vat=($vat==0)?1:$vat;
		}

		return $vat;
	}

}

?>