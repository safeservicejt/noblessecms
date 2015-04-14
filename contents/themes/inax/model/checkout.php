<?php

function before_checkout($inputData=array())
{
	$inputData['alertLogin']='';	

	if(Request::has('checkoutOptions') && Request::get('checkoutOptions')=='register')
	{
		Redirect::to(Url::register());
	}

	if(Request::has('btnLogin'))
	{
		$valid=Users::makeLogin();

		if(!$valid)
		{
			$inputData['alertLogin']='<div class="alert alert-warning">Error. Check your login info again !</div>';
		}
		else
		{
			Redirect::to(Url::checkout());
		}
	}

	// Model::load('api/cart');	
	if(!function_exists('jsonData'))
	{
		Model::load('api/cart');				
	}
		
	$inputData['isLogined']=(Users::isLogined()==true)?'yes':'no';

	$inputData['step1_status']=($inputData['isLogined']=='yes')?'none':'block';

	$inputData['step1_status']='display:'.$inputData['step1_status'].';';

	$inputData['step2_status']=($inputData['isLogined']=='yes')?'block':'none';

	$inputData['step2_status']='display:'.$inputData['step2_status'].';';


	// List countries
	if(!$listCountries=Cache::loadKey('listCountries',-1))
	{
		$inputData['listCountries']='';
	}
	else
	{
		$listCountries=json_decode($listCountries,true);

		$totalCountries=count($listCountries);

		$li='';

		for($i=0;$i<$totalCountries;$i++)
		{
			$li.='<option value="'.$listCountries[$i]['iso_code_2'].'">'.$listCountries[$i]['name'].'</option>';
		}

		$inputData['listCountries']=$li;		
	}

	// Tax
	$listTax=Checkout::tax();

	$taxPrice=$listTax['tax_rate'];

	$getData=Currency::parsePrice($taxPrice);

	$fullPrice='';

	if($listTax['tax_type']=='fixedamount')
	{
		$fullPrice=$getData['format'];		
	}
	if($listTax['tax_type']=='percent')
	{
		$fullPrice=$taxPrice.' %';		
	}

	$li='

		<!-- Row -->
		  <div class="row">
		    <div class="col-lg-10">
		    <span>
		    <span>'.$listTax['tax_title'].'</span>
		                                     
		    </div>
		    <div class="col-lg-2 text-right"><span>'.$fullPrice.'</span> </div>

		  </div>
		  <!-- Row -->

	';

	$inputData['theTax']=$li;


	// Payment methods

	$paymentMethodsForm=Paymentmethods::load('require_form_on_checkout');

	$paymentMethods=Paymentmethods::load('methods_array');



	$inputData['paymentMethodsForm']=$paymentMethodsForm;

	$total=count($paymentMethods);

	$li='';

	for($i=0;$i<$total;$i++)
	{
		$li.='

			<p>
                <input type="radio" class="thePaymentMethod" id="'.$paymentMethods[$i]['foldername'].'" title="'.$paymentMethods[$i]['title'].'" name="paymentMethod" value="'.$paymentMethods[$i]['foldername'].'" /> <label class="thePointer" for="'.$paymentMethods[$i]['foldername'].'"> '.$paymentMethods[$i]['title'].'</label>
              </p>
		';
	}

	$inputData['paymentMethods']=$li;

	// print_r($inputData['paymentMethods']);die();

	// Cart data
	// $content=jsonData();

	// $content=json_decode($content,true);

	$inputData['theCart']=Checkout::total();

	// print_r($inputData['theCart']);die();

	$getData=Currency::parsePrice($inputData['theCart']['subtotal']);

	$inputData['theCart']['subtotal']=$getData['real'];
	$inputData['theCart']['subtotalFormat']=$getData['format'];

	$getData=Currency::parsePrice($inputData['theCart']['total']);

	$inputData['theCart']['total']=$getData['real'];
	$inputData['theCart']['totalFormat']=$getData['format'];

	
	$getData=Currency::parsePrice($inputData['theCart']['total_tax']);

	$inputData['theCart']['total_tax']=$getData['real'];
	$inputData['theCart']['total_taxFormat']=$getData['format'];

	


	$inputData['userid']=0;

	$inputData['user']=array();

	if(Session::has('userid'))
	{	
		$userid=Session::get('userid');

		$loadUser=Address::get(array(
			'where'=>"where userid='$userid'"
			));

		$inputData['billing']=$loadUser[0];
	}


	return $inputData;
}


?>