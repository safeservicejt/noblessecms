var site_url='';
var api_url='';

var command='';

var isConfirmShippingRate='no';
var isSelectedShippingRate='no';


function documentReady(func)
{
  $(document).ready(function(){
    func();
  });  
}

function loadCartPopup()
{
    var template=$('.cart-total-summary').data('template');

    var request = new XMLHttpRequest();
    request.open('POST', api_url+'get_cart_popup_content', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);

        var msg = JSON.parse(request.responseText);

        if(msg['error']=='no')
        {
          var cartPo=$('.wrap-cart-popup');

          if(cartPo.length > 0)
            {
                $('.wrap-cart-popup').html(msg['data']);
            }
        }


      } else {
        // We reached our target server, but it returned an error
        


      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      


    };

    request.send('send_template='+template);

}

function removeOnCart(productid)
{
    var request = new XMLHttpRequest();
    request.open('POST', api_url+'remove_on_cart', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        if(msg['error']=='no')
        {
          loadCartPopup();
        }


      } else {
        // We reached our target server, but it returned an error
        


      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      


    };

    request.send("send_productid="+productid);

}

function refreshPage()
{
   location.href=location.href;
}


function removeOnCartPageCallBack(theEl,productid,callback)
{
  coreRemoveOnCartPage(theEl,productid,callback);
}

function removeOnCartPage(theEl,productid)
{    
  coreRemoveOnCartPage(theEl,productid,function(){});
}

function coreRemoveOnCartPage(theEl,productid,callback)
{
    var request = new XMLHttpRequest();
    request.open('POST', api_url+'remove_on_cart', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        if(msg['error']=='no')
        {
        	theEl.parent().parent().parent().parent().remove();

          refreshPage();
        }


      } else {
        // We reached our target server, but it returned an error
        


      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      


    };

    request.send("send_productid="+productid);

}

function updateOnCartCallBack(productid,quantity,callback)
{
  coreUpdateOnCart(productid,quantity,callback);
}

function updateOnCart(productid,quantity)
{    
  coreUpdateOnCart(productid,quantity,function(){});
}

function coreUpdateOnCart(productid,quantity,callback)
{
    var request = new XMLHttpRequest();
    request.open('POST', api_url+'update_on_cart', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        if(msg['error']=='no')
        {
        	refreshPage();
        }


      } else {
        // We reached our target server, but it returned an error
        


      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      


    };

    request.send("send_productid="+productid+"&send_quantity="+quantity);

}

function addToCartCallBack(productid,quantity,callback)
{
  coreAddToCart(productid,quantity,callback);
}

function addToCart(productid,quantity)
{    
  coreAddToCart(productid,quantity,function(){});
}

function coreAddToCart(productid,quantity,callback)
{
    var attr='';

    if($('.product_attr_key').length > 0)
    {
      var totalAttr=$('.product_attr_key').length;

      var keyName='';

      var keyVal='';

      for(var i=0;i<totalAttr;i++)
      {
        keyName=$('.product_attr_key:eq('+i+')').text();

        keyVal=$('.product_attr_val:eq('+i+')').children('option:selected').attr('value');

        attr+=keyName+':'+keyVal+' \n ';
      }

    }

    var request = new XMLHttpRequest();
    request.open('POST', api_url+'add_to_cart', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);

        var msg = JSON.parse(request.responseText);
      
        if(msg['error']=='no')
        {
          
          loadCartPopup();

          if(typeof(msg['data']) != null || typeof(msg['data']['redirect']) !== "undefined")
            {
                location.href=msg['data']['url'];
            }
            else
            {
              
            }
        }
        else
        {
          alert(msg['message']);
        }


      } else {
        // We reached our target server, but it returned an error
        


      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      


    };

    request.send("send_productid="+productid+"&send_quantity="+quantity+"&send_attr="+attr);

}


function updateTax()
{    
    var billingCountry=$('.txt-billing-country').children('option:selected').attr('value');

    var shippingCountry=$('.txt-shipping-country').children('option:selected').attr('value');

    isSameBilling='no';

    if($('#shippingSame').prop('checked')==true)
    {
      isSameBilling='yes';
    }

    var request = new XMLHttpRequest();
    request.open('POST', api_url+'get_update_tax', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);

        var msg = JSON.parse(request.responseText);
      
        if(msg['error']=='no')
        {
          $('.show-shipping-fee').html(msg['data']['shipping_feeFormat']);
          $('.show-tax-fee').html(msg['data']['taxFormat']);
          $('.show-total-money').html(msg['data']['totalFormat']);
        }


      } else {
        // We reached our target server, but it returned an error
        


      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      


    };

    request.send("send_shipping_country="+shippingCountry+"&send_billing_country="+billingCountry+"&send_issamebilling="+isSameBilling);

}

function updateShippingRate(id)
{    
    var request = new XMLHttpRequest();
    request.open('POST', api_url+'get_update_shipping_rate', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);

        var msg = JSON.parse(request.responseText);
      
        if(msg['error']=='no')
        {
          $('.show-shipping-fee').html(msg['data']['shipping_feeFormat']);
          $('.show-tax-fee').html(msg['data']['taxFormat']);
          $('.show-total-money').html(msg['data']['totalFormat']);

          isConfirmShippingRate='yes';
        }


      } else {
        // We reached our target server, but it returned an error
        


      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      


    };

    request.send("send_id="+id);

}

function sendFormDataOnFly(toUrl,callback)
{
  var formData={};

  $('input').each(function(index, el) {
    var theEl=$(this);

    var type=$(this).attr('type');

    var inputName=theEl.attr('name');

    if(typeof inputName!== "undefined")
    {
      if(type=='radio')
      {
        if(theEl.prop('checked')==true)
        {
          formData[inputName]=theEl.val();
        }
      }
      else if(type=='checkbox')
      {
        if(theEl.prop('checked')==true)
        {
          formData[inputName]=theEl.val();
        }
      }
      else
      {
        formData[inputName]=theEl.val();
      }    
    }


  });

  $('textarea').each(function(index, el) {
    var theEl=$(this);

    var type=$(this).attr('type');

    var inputName=theEl.attr('name');

    if(typeof inputName!== "undefined")
    {
      formData[inputName]=theEl.val();  
    }

  });

  $('select').each(function(index, el) {
    var theEl=$(this);

    var type=$(this).attr('type');

    var inputName=theEl.attr('name');

    if(typeof inputName!== "undefined")
    {
      formData[inputName]=theEl.children('option:selected').attr('value');  
    }

  });

  var send_data=JSON.stringify(formData);

  var request = new XMLHttpRequest();
  request.open('POST', toUrl, true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

  request.onload = function() {
    if (request.status >= 200 && request.status < 400) {
      // Success!
      // var data = JSON.parse(request.responseText);
      callback(request.responseText);
      
    } else {
      // We reached our target server, but it returned an error
      
      alert('Error connection. Check your internet connection again!');

    }
  };

  request.onerror = function() {
    // There was a connection error of some sort
    alert('Error connection. Check your internet connection again!');
    


  };

  request.send("send_form_data="+send_data);
}

function confirmOrder()
{    

  var orderData={};

  // Billing information
  orderData['email']=$('.txt-billing-email').val();

  orderData['billing_firstname']=$('.txt-billing-firstname').val();

  orderData['billing_lastname']=$('.txt-billing-lastname').val();

  orderData['billing_phone']=$('.txt-billing-phone').val();

  orderData['billing_company']=$('.txt-billing-company').val();

  orderData['billing_address1']=$('.txt-billing-address1').val();

  orderData['billing_address2']=$('.txt-billing-address2').val();

  orderData['billing_city']=$('.txt-billing-city').val();

  orderData['billing_postcode']=$('.txt-billing-postcode').val();

  orderData['billing_state']=$('.txt-billing-state').val();

  orderData['billing_country']=$('.txt-billing-country').children('option:selected').attr('value');

  orderData['billing_country_name']=$('.txt-billing-country').children('option:selected').text();

  // Shipping information
  orderData['shipping_firstname']=$('.txt-shipping-firstname').val();

  orderData['shipping_lastname']=$('.txt-shipping-lastname').val();

  orderData['shipping_phone']=$('.txt-shipping-phone').val();

  orderData['shipping_company']=$('.txt-shipping-company').val();

  orderData['shipping_address1']=$('.txt-shipping-address1').val();

  orderData['shipping_address2']=$('.txt-shipping-address2').val();

  orderData['shipping_city']=$('.txt-shipping-city').val();

  orderData['shipping_postcode']=$('.txt-shipping-postcode').val();

  orderData['shipping_state']=$('.txt-shipping-state').val();

  orderData['shipping_country']=$('.txt-shipping-country').children('option:selected').attr('value');

  orderData['shipping_country_name']=$('.txt-shipping-country').children('option:selected').text();

  // if(orderData['shipping_firstname'].length < 2 || orderData['shipping_lastname'].length < 2 || orderData['shipping_phone'].length < 2 || orderData['shipping_address1'].length < 2 || orderData['shipping_city'].length < 2 || orderData['shipping_postcode'].length < 2 || orderData['shipping_state'].length < 2 || orderData['shipping_country'].length < 2)
  // {
  //   alert('Error. Check your shipping information again.');
  //   return false;
  // }

  orderData['shipping_same']=$('#shippingSame').val();

  if($('#shippingSame').prop('checked')!=true)
  {
    orderData['shipping_same']='no';
  }  

  orderData['order_comment']=$('.txt-order-comment').val();

  orderData['shipping_method']=0;

  $('.input-checkout-shippingrate').each(function(index, el) {

    if($(this).prop('checked')==true)
    {
      orderData['shipping_method']=$(this).val();
    }


  });

  orderData['payment_method']=0;

  $('.input-checkout-payment-method').each(function(index, el) {

    if($(this).prop('checked')==true)
    {
      orderData['payment_method']=$(this).val();
    }


  });

  var send_data=JSON.stringify(orderData);

  var request = new XMLHttpRequest();
  request.open('POST', api_url+'confirm_order', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

  request.onload = function() {
    if (request.status >= 200 && request.status < 400) {
      // Success!
      // var data = JSON.parse(request.responseText);
      var msg = JSON.parse(request.responseText);
    
      if(msg['error']=='no')
      {
        if(typeof(msg['data']) != null && typeof(msg['data']['redirect']) !== "undefined")
          {
            if(typeof(msg['data']['url']) != null || typeof(msg['data']['url']) !== "undefined")
              {
                  msg['data']['url']=site_url+'order_complete';
              }             

              location.href=msg['data']['url'];
          } 
        else if(typeof(msg['data']) != null && typeof(msg['data']['submit_form']) !== "undefined")
          {
              var data=msg['data']['submit_form'];

              $('.wrap_order_submit_form').html(data);

              $('#order_submit_form').submit();

          }
          else
          {
            location.href=site_url+'order_complete';
          }
      }
      else
      {
        alert(msg['message']);
      }


    } else {
      // We reached our target server, but it returned an error
    alert('Internet connection error. Try again!');
      


    }
  };

  request.onerror = function() {
    // There was a connection error of some sort
    alert('Internet connection error. Try again!');


  };

  request.send("send_data="+send_data);

}

function showCheckOutStep(number)
{
  $('.checkout-panel .panel-body').fadeOut('fast');

  var target='panel-step'+number;

  var pos= $('.'+target).children('.panel-body').offset().top;

  $('.'+target+' .panel-body').fadeIn('fast');  

  $('html, body').animate({ scrollTop: pos+'px' }, 'slow'); 
}


$(document).ready(function(){
  site_url=$('meta[id="root_url"]').attr('content');

  api_url=site_url+'api/plugin/fastecommerce/';

  loadCartPopup();

  $('.select_go_to_url').change(function(){

    var url=$(this).children('option:selected').attr('value');

    if(url.length > 10)
    {
      location.href=url;
    }
    

  });

});



$( document ).on( "click", ".cart-popup .cart-total-summary", function() {
  $('.cart-popup .details-popup').toggle();
}); 

$( document ).on( "click", ".remove-product", function() {
  var id=$(this).attr('data-id');

  removeOnCart(id);
}); 

$( document ).on( "click", ".btn-remove-product-cart-page", function() {

  var id=$(this).attr('data-id');

  var theEl=$(this);

  removeOnCartPage(theEl,id);


}); 

$( document ).on( "click", ".btn-update-product-cart-page", function() {

  var id=$(this).attr('data-id');

  var quantity=$('.quantity-'+id).val();

  updateOnCart(id,quantity);


}); 

$( document ).on( "click", ".checkout-panel .panel-title", function() {

  $('.checkout-panel .panel-body').fadeOut('fast');

  var pos= $(this).parent().parent().children('.panel-body').offset().top;

  $(this).parent().parent().children('.panel-body').fadeIn('fast');

  $('html, body').animate({ scrollTop: pos+'px' }, 'slow'); 

}); 

$( document ).on( "click", ".btn-next-step", function() {

  $('.checkout-panel .panel-body').fadeOut('fast');

  var target=$(this).attr('data-target');

  var pos= $('.'+target).children('.panel-body').offset().top;

  $('.'+target+' .panel-body').fadeIn('fast');

  $('html, body').animate({ scrollTop: pos+'px' }, 'slow'); 

}); 

$( document ).on( "click", ".checkout-panel .panel-title", function() {

  var txt=$(this).html();

  if(txt.indexOf('Step 6')!=-1)
  {
    if(isSelectedShippingRate=='no' || isConfirmShippingRate=='no')
    {
      showCheckOutStep(4);
    }

    updateTax();
  }

}); 

$( document ).on( "click", ".input-checkout-shippingrate", function() {

  var el=$(this);

  var id=$(this).attr('value');

  updateShippingRate(id);
  updateShippingRate(id);

  isSelectedShippingRate='yes';

}); 

$( document ).on( "change", ".txt-shipping-country", function() {

  var id=$(this).children('option:selected').attr('value');

  updateShippingRate(id);
  updateShippingRate(id);

  isSelectedShippingRate='yes';

}); 

$( document ).on( "click", ".btn-next-step", function() {

  var target=$(this).attr('data-target');

  if(target=='panel-step6')
  {
    updateTax();
    updateTax();
  }

}); 


$( document ).on( "click", "#btnConfirm", function() {

  confirmOrder();

}); 

$( document ).on( "click", "img.sub_thumbnail", function() {

  var img=$(this).attr('src');

  $('.main-image').html('<img src="'+img+'" />');

  
}); 


$( document ).on( "click", ".btn-add-to-cart", function() {

  var id=$(this).data('id');

  var quantity=$('.input-product-quantity').val();

  addToCart(id,quantity);

}); 


$( document ).on( "click", ".rating > .full", function() {

  $('.rating > input[name="rating"]').each(function(index, el) {
    $(this).attr('checked',false);
    
  });

  var target=$(this).attr('for');

  $('#'+target).attr('checked',true);
  
  $('.txt-rating-val').val($('#'+target).val());

}); 


