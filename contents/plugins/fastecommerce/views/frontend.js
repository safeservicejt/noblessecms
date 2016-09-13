
var api_url=$("meta[id='root_url']").attr("content");

api_url=api_url+'api/plugin/fastecommerce/';

var lang=new Array();


function systemLoadLanguage()
{
	$.ajax({
   type: "POST",
   url: api_url+'get_frontend_lang',
   dataType: "json",
   success: function(msg)
					{
						// alert(msg);return;

						lang=msg['data'];

						// alert(lang['alert']);

					 }
		 });	
}
function addToCart(prodID)
{
	$.ajax({
   type: "POST",
   url: api_url+'add_to_cart',
   data: ({
		  send_productid : prodID
		  }),
   dataType: "json",
   success: function(msg)
					{

						// alert(msg);return false;
						
						if(msg['error']=='yes')
						{
						 	setError(lang['addProduct']['error']);
						}
						else
						{
							setSuccess(lang['addProduct']['success']);

						}

						cartData();

			 			toTop();
					 }
		 });	
}
function updateProduct(prodID,quant)
{
	$.ajax({
   type: "POST",
   url: api_url+'update_from_cart',
   data: ({
		  send_productid : prodID,
		  send_quantity : quant
		  }),
   dataType: "json",
   success: function(msg)
					{
						// setSuccess('Update product from shopping cart successful!');

						if(msg['error']=='yes')
						{
						 	setError(lang['updateProduct']['error']);
						}
						else
						{
							refresh();
						}

						cartData();

			 			toTop();
					 }
		 });	
}

function removeProduct(prodID)
{
	$.ajax({
   type: "POST",
   url: api_url+'remove_from_cart',
   data: ({
		  send_productid : prodID
		  }),
   dataType: "json",
   success: function(msg)
					{
						
						// setSuccess('Remove product from shopping cart successful!');

						if(msg['error']=='yes')
						{
						 	setError(lang['removeProduct']['error']);
						}
						else
						{
							refresh();	
						}

						cartData();

			 			toTop();
					 }
		 });	
}


function clearCart()
{
	$.ajax({
   type: "POST",
   url: api_url+'clear_cart',
   dataType: "html",
   success: function(msg)
					{
						
					 }
		 });	
}

function cartData()
{
	if($('#theCartData').length == 0)
	{
		return;
	}	

	$.ajax({
   type: "POST",
   url: api_url+'get_cart_html_data',
   dataType: "html",
   success: function(msg)
					{
						// alert(msg);return;
						$('#theCartData').html(msg);
					 }
		 });	
}

function toTop()
{
	$('html, body').animate({ scrollTop: 0 }, 'slow'); 
}

function setSuccess(str)
{
	$('#shop_notify').html('<div class="alert alert-success">'+str+'</div>');
}

function setError(str)
{
	$('#shop_notify').html('<div class="alert alert-warning">'+str+'</div>');
}


function refresh()
{
	location.href=location.href;
}


$( document ).on( "click", "#billSameasShipping", function() {
	if($(this).is(':checked'))
	{
		$('.Deliveryinfo').slideUp('slow');
	}
	else
	{
		$('.Deliveryinfo').slideDown('slow');
	}
});	

$( document ).on( "click", ".addToCart", function() {
	var prodid=$(this).attr('data-id');

	addToCart(prodid);
});	


$( document ).on( "click", ".btnUpdateQuantity", function() {
	var prodid=$(this).attr('data-id');

	var quantity=$(this).parent().children('input[type="text"]').val();

	updateProduct(prodid,quantity);
});	

$( document ).on( "click", ".btnRemoveProd", function() {


	if(confirm(lang['removeProduct']['alert']))
	{
		var prodid=$(this).attr('data-id');

		removeProduct(prodid);			
	}	

});		

$( document ).on( "click", ".coupon", function() {

	$('div.divCoupon').show();

	$('div.divVoucher').hide();

});		

$( document ).on( "click", ".voucher", function() {

	$('div.divCoupon').hide();

	$('div.divVoucher').show();

});		

$( document ).on( "click", ".btnAddCoupon", function() {



	var couponCode=$('#discountCode').val();

	$.ajax({
   type: "POST",
   url: api_url+'add_coupon',
   data: ({
		  coupon : couponCode
		  }),
   dataType: "html",
   success: function(msg)
					{

						alert(msg);return false;
						setSuccess(lang['addCoupon']['success']);
						
						if(msg['error']=='yes')
						{
						 	setError(lang['addCoupon']['error']);
						}
						else
						{
							location.href=location.href;
						}

			 			toTop();
					 }
		 });

});		


$( document ).on( "click", ".btnAddVoucher", function() {


	var voucherCode=$('#disvoucherCode').val();

	$.ajax({
   type: "POST",
   url: api_url+'add_voucher',
   data: ({
		  voucher : voucherCode
		  }),
   dataType: "json",
   success: function(msg)
					{

						// alert(msg);return false;
						setSuccess(lang['addVoucher']['success']);
						
						if(msg['error']=='yes')
						{
						 	setError(lang['addVoucher']['error']);
						}
						else
						{
							location.href=location.href;
						}
						
			 			toTop();
					 }
		 });

});		


// Cart click
$( document ).on( "click", "#cart > div.heading > a", function() {

	$('#cart div.content').toggle();

});	

$(document).ready(function(){

	systemLoadLanguage();

	
});