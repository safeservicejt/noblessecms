<?php

function cartContent()
{
	Model::load('api/cart');

	$loadData=array();

	$content=jsonData();

	$content=json_decode($content,true);

	// print_r($content);die();

	if(!isset($content['items'][0]))
	{

		$loadData['listProd']='
		<tr>
		<td colspan="5">You not have any item in cart.</td>
		</tr>
		';

		$content['total']=0;

		$content['subtotal']=0;

		$content['vat']=0;

		$content['totalvat']=0;

	}
	else
	{
		// print_r($content);die();

		$total=count($content['items']);

		$li='';

		if($total > 0)
		for($i=0;$i<$total;$i++)
		{
				$getProdPriceData=Currency::parsePrice($content['items'][$i]['price']);

				$content['items'][$i]['price']=$getProdPriceData['real'];

				$content['items'][$i]['priceFormat']=$getProdPriceData['format'];	

				$getProdPriceData=Currency::parsePrice($content['items'][$i]['totalPrice']);

				$content['items'][$i]['totalPrice']=$getProdPriceData['real'];

				$content['items'][$i]['totalPriceFormat']=$getProdPriceData['format'];	


			$li.='

				<!-- Tr -->
				<tr>
				    <td><img src="'.$content['items'][$i]['image'].'" class="img-responsive" /></td>
				    <td><a href="'.$content['items'][$i]['url'].'">'.$content['items'][$i]['title'].'</a></td>
				  <td>
				  <input type="text" value="'.$content['items'][$i]['totalInCart'].'" size="5" />
				  <button type="button" id="btnUpdateQuantity" data-productid="'.$content['items'][$i]['productid'].'" class="btn btn-primary" title="Update Quantity"><span class="glyphicon glyphicon-refresh"></span></button>
				   <button type="button" id="btnRemoveProd" data-productid="'.$content['items'][$i]['productid'].'"  class="btn btn-primary" title="Remove Product"><span class="glyphicon glyphicon-remove"></span></button>
				 
				  </td>

				  <td class="text-right">
				  '.$content['items'][$i]['priceFormat'].'
				    </td>
				  <td class="text-right">
				  '.$content['items'][$i]['totalPriceFormat'].'
				    </td>
				</tr>
				<!-- Tr -->

			';
		}

		$loadData['listProd']=$li;

		$getPriceData=Currency::parsePrice($content['discount']);	

		$loadData['discount']=$getPriceData['real'];
		$loadData['discountFormat']=$getPriceData['format'];	

	}
	
	$getPriceData=Currency::parsePrice($content['total']);

	$loadData['total']=$getPriceData['real'];
	$loadData['totalFormat']=$getPriceData['format'];

	$getPriceData=Currency::parsePrice($content['subtotal']);		

	$loadData['subtotal']=$getPriceData['real'];
	$loadData['subtotalFormat']=$getPriceData['format'];

	// $getPriceData=Currency::parsePrice($content['vat']);	

	// $loadData['vat']=$getPriceData['real'];
	// $loadData['vatFormat']=$getPriceData['format'];

	// if((int)$content['vat']==1)
	// {
	// 	$content['vat']=0;
	// }
	
	$loadData['vat']=$content['vat'];

	// print_r($content);die();

	$getPriceData=Currency::parsePrice($content['totalvat']);	

	$loadData['totalvat']=$getPriceData['real'];	
	$loadData['totalvatFormat']=$getPriceData['format'];

	return $loadData;

}

?>