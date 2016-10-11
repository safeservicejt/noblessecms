var root_url='';

function writeNotify(str)
{
	$('#notify').html(str);
}

function alertSuccess(str)
{
	writeNotify('<div class="alert alert-success">'+str+'</div>');
}

function alertWarning(str)
{
	writeNotify('<div class="alert alert-warning">'+str+'</div>');
}

$(document).ready(function(){

	root_url=$("meta[id='root_url']").attr("content");


	$('img.js-auto-responsive').each(function(){

		var src=$(this).attr('data-src');

		$(this).attr('src',src).addClass('img-responsive');

	});

	$('#selectAll').click(function(){
		
		 var c = this.checked;
	    $(':checkbox').prop('checked',c);
	});	
	
	
	$('img.js-auto').each(function(){

		var src=$(this).attr('data-src');

		$(this).attr('src',src);

	});

	$('img').each(function(){

		var alt=$(this).attr('alt');
		var src=$(this).attr('src');

		if(!alt)
		{
			$(this).attr('alt',src);
		}
	});

	$('#btnLogin').click(function(){

		var txtUsername=$('#txtUsername').val();

		var txtPassword=$('#txtPassword').val();

		if(txtUsername.length < 3 || txtPassword.length < 3)
		{
			return false;
		}

		$.ajax({
	   type: "POST",
	   url: root_url+"api/user/login",
	   data: ({
			  username : txtUsername,
			  password : txtPassword

			  }),
	   dataType: "json",
	   success: function(msg)
						{
							 if(msg['error']!='yes')
							 {
							 	location.href=root_url+'admincp';
							 }
							 else
							 {
							 	alertWarning(msg['message']);
							 }
						 }
			 });		
	});
	
});

