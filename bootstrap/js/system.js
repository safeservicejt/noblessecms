


$(document).ready(function(){

	$('img.js-auto-responsive').each(function(){

		var src=$(this).attr('data-src');

		$(this).attr('src',src).addClass('img-responsive');

	});
	
	$('img.js-auto').each(function(){

		var src=$(this).attr('data-src');

		$(this).attr('src',src);

	});


});