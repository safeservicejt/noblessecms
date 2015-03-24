<?php


function processCart()
{
	if(!$matches=Uri::match('api\/cart\/(\w+)'))
	{
		return '';
	}

	$methodName=$matches[1];

	// print_r($methodName);die();

	switch ($methodName) {

		case 'addProduct':
			
			$valid=addProduct();

			if(!$valid)
			{
				return 'ERROR';
			}

			return 'OK';

			break;
		case 'updateProduct':

		if(!isset($_SESSION['cart']))
		{
			return 'ERROR';
		}
			
			$valid=updateProduct();

			if(!$valid)
			{
				return 'ERROR';
			}

			return 'OK';

			break;
		case 'removeProduct':

		if(!isset($_SESSION['cart']))
		{
			return 'ERROR';
		}

			removeProduct();

			return 'OK';

			break;
		case 'clearCart':

		if(!isset($_SESSION['cart']))
		{
			return 'ERROR';
		}

			clearCart();

			break;
		case 'jsonData':
	
			$valid=jsonData();

			return $valid;

			break;

		case 'htmlData':

			$valid=htmlData();

			return $valid;

			break;

		case 'saveCoupon':
		
		if(!isset($_SESSION['cart']))
		{
			return 'ERROR';
		}

			$valid=saveCoupon();

			return $valid;

			break;

		case 'saveVoucher':
		
		if(!isset($_SESSION['cart']))
		{
			return 'ERROR';
		}

			$valid=saveVoucher();

			return $valid;

			break;
		

	}

}

function saveVoucher()
{
	if(Request::has('voucher')==false)
	{
		die('ERROR');
	}

	$id=trim(Request::get('voucher'));

	// die($id);	

	$valid=Validator::make(array(
		'voucher'=>'min:20|slashes'
		));

	if(!$valid)
	{
		die('ERROR');
	}

	if(isset($_SESSION['discount']['voucher']))
	{
		$total=count($_SESSION['discount']['voucher']);

		for($i=0;$i<$total;$i++)
		{
			if($_SESSION['discount']['voucher'][$i]['code']==$id)
			{
				die('ERROR');
				
				break;				
			}
		}
	}
	DBCache::disable();
	$loadData=Vouchers::get(array(
		'where'=>"where code='$id'"
		));
	DBCache::enable();
	if(!isset($loadData[0]['code']))
	{
		die('ERROR');
	}	

	$total=0;

	if(is_array($_SESSION['discount']['voucher']))
	{
		$total=count($_SESSION['discount']['voucher']);
	}

	$_SESSION['discount']['voucher'][$total]['code']=$id;

	$_SESSION['discount']['voucher'][$total]['voucherid']=$loadData[$i]['voucherid'];

	$_SESSION['discount']['voucher'][$total]['balance']=$loadData[$i]['amount'];

	die('OK');
}
function saveCoupon()
{
	if(Request::has('coupon')==false)
	{
		die('ERROR');
	}

	$id=trim(Request::get('coupon'));	

	$valid=Validator::make(array(
		'coupon'=>'min:20|slashes'
		));

	if(!$valid)
	{
		die('ERROR');
	}

	if(isset($_SESSION['discount']['coupon']) && in_array($id, $_SESSION['discount']['coupon']))
	{
		die('ERROR');		
	}
	DBCache::disable();
	$loadData=Coupons::get(array(
		'where'=>"where coupon_code='$id'"
		));
	DBCache::enable();
	if(!isset($loadData[0]['coupon_code']))
	{
		die('ERROR');
	}	

	$_SESSION['discount']['coupon'][]=$id;

	die('OK');
}

function addProduct()
{
	if(Request::has('productid')==false)
	{
		return false;
	}

	$id=Request::get('productid');

	$valid=Validator::make(array(
		'productid'=>'min:10|slashes'
		));

	if(!$valid)
	{
		return false;
	}

	DBCache::disable();

	$loadData=Products::get(array(
		'selectFields'=>'minimum,quantity',
		'where'=>"where productid='$id'",
		'isHook'=>'no'
		));
	
	DBCache::enable();

	if(!$loadData)
	{

		return false;
	}

	$minimum=$loadData[0]['minimum'];

	$quantity=$loadData[0]['quantity'];

	if((int)$quantity==0)
	{
		return false;
	}

	Cart::add($id,$minimum);

	return true;

}

function updateProduct()
{
	if(Request::has('productid')==false || Request::has('quantity')==false)
	{
		return false;
	}

	$id=Request::get('productid');

	$quantity=Request::get('quantity');

	$valid=Validator::make(array(
		'productid'=>'slashes|min:10',
		'quantity'=>'slashes|number'
		));

	if(!$valid)
	{
		return false;
	}


	DBCache::disable();

	$loadData=Products::get(array(
		'selectFields'=>'minimum,quantity',
		'where'=>"where productid='$id'",
		'isHook'=>'no'
		));

	DBCache::enable();

	if(!$loadData)
	{
		return false;
	}

	$minimum=$loadData[0]['minimum'];	

	$limit=$loadData[0]['quantity'];	



	if((int)$minimum > (int)$limit || (int)$minimum > (int)$quantity || (int)$quantity > (int)$limit)
	{	
		return false;
	}

	Cart::remove($id);

	Cart::add($id,$quantity);

	return true;

}

function removeProduct()
{
	if(Request::has('productid')==false)
	{
		return false;
	}

	$id=Request::get('productid');

	$valid=Validator::make(array(
		'productid'=>'slashes|min:10'
		));

	if(!$valid)
	{
		return false;
	}

	Cart::remove($id);
}

function clearCart()
{
	Cart::clear();
}

function jsonData()
{
	if(!isset($_SESSION['cart']))
	{
		$data=array();

		return json_encode($data);
	}

	$resultData=array();

	$loadData=Cart::data();

	$totalProd=count($loadData);

	// print_r($loadData);die();

	$cartUrl=Url::cart();

	$checkoutUrl=Url::checkout();

	if($totalProd==0)
	{
		return json_encode($resultData);
	}

	$cartPrice=0;

	$totalPrice=0;	

	$resultData['items']=$loadData;

	// print_r($loadData);die();



	for($i=0;$i<$totalProd;$i++)
	{
		// $theItem=$loadData[$i];

		$resultData['items'][$i]['price']=Currency::insertPrice($resultData['items'][$i]['price']);
		
		$theItem=$resultData['items'][$i];

		$prodID=$theItem['productid'];//productNodeid

		if(!isset($_SESSION['cart'][$prodID]))
		{
			continue;
		}
		$numInCart=$_SESSION['cart'][$prodID];

		// $theItem['price']=Currency::insertPrice($theItem['price']);

		$totalPrice=(int)$numInCart*(double)$theItem['price'];

		$resultData['items'][$i]['totalPrice']=$totalPrice;
		$resultData['items'][$i]['totalInCart']=$numInCart;
		
		$cartPrice+=(double)$totalPrice;
	}

	// print_r($resultData['items']);die();

	$resultData['subtotal']=$cartPrice;

	// echo $resultData['subtotal'];die();

	$resultData=Cart::discountProcess($resultData);

	$theVAT=Cart::theVAT();

	// print_r($theVAT);die();

	$totalVAT=0;

	if($theVAT > 1 && (double)$resultData['subtotal'] > 0)
	{
		$totalVAT=((double)$cartPrice*(double)$theVAT)/100;		
	}

	// $resultData['subtotal']=;		

	$resultData['total']=(double)$resultData['subtotal']+(double)$totalVAT;

	$resultData['vat']=$theVAT;

	$resultData['totalvat']=$totalVAT;

	return json_encode($resultData);
}

function htmlData()
{

	$loadData=array();

	if(!isset($_SESSION['cart']))
	{
		$tableProd='
		<div class="empty">Your shopping cart is empty!</div>
		';		

		$totalProd=0;

		$getData=Currency::parsePrice(0);

		$loadData['totalFormat']=$getData['format'];
	}
	else
	{
		$loadData=jsonData();

		$loadData=json_decode($loadData,true);

		$getPriceData=Currency::parsePrice($loadData['total']);	

		$loadData['total']=$getPriceData['real'];

		$loadData['totalFormat']=$getPriceData['format'];

		$getPriceData=Currency::parsePrice($loadData['totalvat']);	

		$loadData['totalvat']=$getPriceData['real'];

		$loadData['totalvatFormat']=$getPriceData['format'];

		$getPriceData=Currency::parsePrice($loadData['subtotal']);	

		$loadData['subtotal']=$getPriceData['real'];

		$loadData['subtotalFormat']=$getPriceData['format'];


		$totalProd=count($loadData['items']);

		$trProd='';

		$tableProd='';

		if((int)$totalProd==0)
		{
			$tableProd='
			<div class="empty">Your shopping cart is empty!</div>
			';
		}
		else
		{
			$cartUrl=Url::cart();

			$checkoutUrl=Url::checkout();

			// print_r($loadData);die();

			for($i=0;$i<$totalProd;$i++)
			{
				$theItem=$loadData['items'][$i];

				$trProd.='

				<tr>
		          <td class="image"> <a href="'.$theItem['url'].'"><img src="'.$theItem['image'].'" alt="'.$theItem['title'].'" title="'.$theItem['title'].'"></a>
		            </td>
		          <td class="name"><a href="'.$theItem['url'].'">'.$theItem['title'].'</a>
		            <div>
		            </div></td>
		          <td class="quantity">x&nbsp;'.$theItem['totalInCart'].'</td>
		          <td class="total">'.$theItem['priceFormat'].'</td>
		          <td class="remove"><img src="'.ROOT_URL.'bootstrap/cart/remove-small.png" id="cartRemoveProd" data-productid="'.$theItem['productid'].'" alt="Remove" title="Remove"></td>
		        </tr>		

				';

			}



			$tableProd='
		 		<div class="mini-cart-info">
			      <table>
			                <tbody>

			                '.$trProd.'

			                </tbody>
			      </table>
			    </div>

			    <div class="mini-cart-total">
			      <table>
			                <tbody>
			                <tr>
			          <td class="right"><b>VAT ('.$loadData['vat'].'%):</b></td>
			          <td class="right">'.$loadData['totalvatFormat'].'</td>
			        </tr>
			                <tr>
			          <td class="right"><b>Total:</b></td>
			          <td class="right">'.$loadData['totalFormat'].'</td>
			        </tr>
			              </tbody></table>
			    </div>
			    <div class="checkout"><a href="'.$cartUrl.'">View Cart</a> | <a href="'.$checkoutUrl.'">Checkout</a></div>		    
			';
		}		
	}






	$resultData='

	<div id="cart">
	  <div class="heading">
	    <h4>Shopping Cart</h4>
	    <a>
	    <span id="cart-total">'.$totalProd.' item(s) - '.$loadData['totalFormat'].'</span>
	    </a>
	  </div>
  		<div class="content" style="display: none;">
       '.$tableProd.'
      	</div>
	</div>

	';

	return $resultData;
}




?>