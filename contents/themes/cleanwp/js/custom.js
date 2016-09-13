

$(document).ready(function(){

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
		
});