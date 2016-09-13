var lang=[];

var api_url='';

var adminUrl='';

function getUserLang(callback)
{
    var request = new XMLHttpRequest();
    request.open('POST', api_url+'get_customer_lang', true);
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

function showContactResponse(classToShow,content)
{
$('.txt-response-result').removeClass('alert-success');
$('.txt-response-result').removeClass('alert-danger');

$('.txt-response-result').addClass('alert').addClass(classToShow).html(content);

}


function showMenu()
{

	var li='';


	li+='<li><a href="'+adminUrl+'admincp/plugins/privatecontroller/fastecommerce/order"><span class="glyphicon glyphicon-globe"></span>&nbsp;'+lang['orders']+'</a></li>';


	$('.navbar-left').append(li);




	li='<li class="dropdown li-adssystem-navbar">';
	li+='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;'+lang['setting']+' <span class="caret"></span></a>';
	li+='<ul class="dropdown-menu dropdown-adssystem-navbar" role="menu">';
	li+='<li class="dropdown"><a href="'+adminUrl+'admincp/plugins/privatecontroller/fastecommerce/affiliate/withdraw" class="dropdown-toggle">'+lang['payments']+'</a></li>';
	// li+='<li class="dropdown"><a href="#" class="dropdown-toggle show-modal-contact">Contact Us</a></li>';

	li+='</ul>';
	li+='</li>';

	$('.navbar-right').prepend(li);	


	li='<li class="li-publisher">';
	li+='<a href="javascript:;" data-toggle="collapse" data-target="#li-publisher"><span class="glyphicon glyphicon-user"></span> '+lang['customer']+' <i class="fa fa-fw fa-caret-down"></i></a>';
	li+='<ul id="li-publisher" class="collapse in" aria-expanded="true">';
	li+='<li><a href="'+adminUrl+'admincp/plugins/privatecontroller/fastecommerce/order">'+lang['orders']+'</a></li>';
	li+='<li><a href="'+adminUrl+'admincp/users/profile">'+lang['accountInformation']+'</a></li>';
	li+='<li><a href="'+adminUrl+'admincp/users/profile">'+lang['changePassword']+'</a></li>';

	li+='</ul>';
	li+='</li>';


	$('.side-nav').append(li);

	li='<li class="li-adsvertiser">';
	li+='<a href="javascript:;" data-toggle="collapse" data-target="#li-adsvertiser"><span class="glyphicon glyphicon-user"></span> '+lang['affiliate']+' <i class="fa fa-fw fa-caret-down"></i></a>';
	li+='<ul id="li-adsvertiser" class="collapse in" aria-expanded="true">';
	// li+='<li><a href="'+adminUrl+'admincp/plugins/privatecontroller/adssystem/adsvertiser/reports">Reports</a></li>';
	li+='<li><a href="'+adminUrl+'admincp/plugins/privatecontroller/fastecommerce/affiliate/report">'+lang['reports']+'</a></li>';
	li+='<li><a href="'+adminUrl+'admincp/plugins/privatecontroller/fastecommerce/affiliate/linkbuilding">'+lang['linkBuilding']+'</a></li>';
	li+='<li><a href="'+adminUrl+'admincp/plugins/privatecontroller/fastecommerce/affiliate/withdraw">'+lang['withdraw']+'</a></li>';
	li+='<li><a href="'+adminUrl+'admincp/plugins/privatecontroller/fastecommerce/affiliate/collection">'+lang['collectionproduct']+'</a></li>';

	li+='</ul>';
	li+='</li>';


	$('.side-nav').append(li);
}

$(document).ready(function(){

	api_url=$('meta[id="root_url"]').attr('content');

	api_url+='api/plugin/fastecommerce/';

	adminUrl=$('.navbar-brand').attr('href');

	getUserLang(function(){

		showMenu();
	});





	$('.show-modal-contact').click(function(){
		$('#contactModal').modal('show');
	});

	$('.btn-send-contact').click(function(){

		var title=$('.txt-contact-title').val();

		var content=$('.txt-contact-content').val();

		if(title.length < 2 || content.length < 10)
		{
			alert('You should type contact information.');

			return false;
		}

	    var request = new XMLHttpRequest();
	    request.open('POST', api_url+'send_contact', true);
	    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

	    request.onload = function() {
	      if (request.status >= 200 && request.status < 400) {
	        // Success!
	        // var data = JSON.parse(request.responseText);
	        var msg = JSON.parse(request.responseText);

	        if(msg['error']=='yes')
	        {
	        	showContactResponse('alert-danger',msg['message']);
	        }
	        else
	        {
	        	showContactResponse('alert-success','Send contact success.');
	        }

	      } else {
	        // We reached our target server, but it returned an error
	       
	        showContactResponse('alert-danger','Error.');

	      }
	    };

	    request.onerror = function() {
	      // There was a connection error of some sort
	       showContactResponse('alert-danger','Error.');
	    };

	    request.send("send_title="+title+"&send_content="+content);
	});


});


$( document ).on( "click", ".btn-customer-cancel-order", function() {

  var url=$(this).data('href');

  if(confirm('Are you want cancel this order ?'))
  {
  	location.href=url;
  }

}); 

