var lang=[];

var api_url='';

var adminUrl='';

function getUserLang(callback)
{
    var request = new XMLHttpRequest();
    request.open('POST', api_url+'get_admincp_lang', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        

        // console.log(lang['orders']);return;

        lang= JSON.parse(msg.data);

        callback();

      } else {
        // We reached our target server, but it returned an error
       

      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
    };

    request.send();
}



function showMenu()
{

	var li='';

	li+='<li class="dropdown li-fastecommerce">';
	li+='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span>&nbsp;&nbsp;'+lang['fastEcommerce']+' <span class="caret"></span></a>';
	li+='<ul class="dropdown-menu dropdown-fastecommerce" role="menu">';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/order">'+lang['orders']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/product">'+lang['products']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/customer">'+lang['customers']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/report">'+lang['reports']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/discount">'+lang['discounts']+'</a></li>';
	// li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/brand">'+lang['brands']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/coupon">'+lang['coupons']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/taxrate">'+lang['taxRates']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/setting/currency">'+lang['currency']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/setting/emailtemplates">'+lang['emailTemplates']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/paymentmethod">'+lang['payments']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/setting">'+lang['settings']+'</a></li>';
	// li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/log">'+lang['logs']+'</a></li>';
	li+='</ul>';
	li+'</li>';

	li+='<li class="dropdown li-fastecommerce">';
	li+='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'+lang['affiliates']+' <span class="caret"></span></a>';
	li+='<ul class="dropdown-menu dropdown-fastecommerce" role="menu">';
	// li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/affiliate">'+lang['listAffiliates']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/affiliate/report">'+lang['reports']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/affiliate/withdraw">'+lang['withdraws']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/affiliate/ranks">Ranks</a></li>';
	// li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/affiliate/collection">'+lang['collectionproduct']+'</a></li>';
	li+='</ul>';
	li+'</li>';

	li+='<li class="dropdown li-fastecommerce">';
	li+='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;'+lang['products']+' <span class="caret"></span></a>';
	li+='<ul class="dropdown-menu dropdown-fastecommerce" role="menu">';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/product">'+lang['listProducts']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/product/addnew">'+lang['addNew']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/review">'+lang['reviews']+'</a></li>';
	li+='</ul>';
	li+'</li>';

	li+='<li class="dropdown li-fastecommerce">';
	li+='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-certificate"></span>&nbsp;&nbsp;Marketing <span class="caret"></span></a>';
	li+='<ul class="dropdown-menu dropdown-fastecommerce" role="menu">';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/order/emailmarketing">Send Email</a></li>';
	li+='</ul>';
	li+'</li>';

	// li+='<li class="dropdown li-fastecommerce">';
	// li+='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Marketing <span class="caret"></span></a>';
	// li+='<ul class="dropdown-menu dropdown-fastecommerce" role="menu">';
	// li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/sendemail">Send Email</a></li>';
	// li+='</ul>';
	// li+'</li>';

	li+='<li class="dropdown li-fastecommerce">';
	li+='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;'+lang['settings']+' <span class="caret"></span></a>';
	li+='<ul class="dropdown-menu dropdown-fastecommerce" role="menu">';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/setting/general">'+lang['general']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/setting/currency">'+lang['currency']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/paymentmethod">'+lang['payments']+'</a></li>';
	li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/setting/shippingrates">'+lang['shipping']+'</a></li>';
	// li+='<li><a href="/admincp/plugins/privatecontroller/fastecommerce/setting/notification">Notifications</a></li>';
	li+='</ul>';
	li+'</li>';
	
	$('.navbar-left').append(li);
}

$(document).ready(function(){

	api_url=$('meta[id="root_url"]').attr('content');

	api_url+='api/plugin/fastecommerce/';

	adminUrl=$('.navbar-brand').attr('href');

	getUserLang(function(){

		showMenu();
	});

});