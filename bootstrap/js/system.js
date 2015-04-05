function ready(fn) {
  if (document.readyState != 'loading'){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

ready(function(){

	$('img.js-auto-responsive').each(function(){

		var src=$(this).attr('data-src');

		$(this).attr('src',src).addClass('img-responsive');

	});
	
	$('img.js-auto').each(function(){

		var src=$(this).attr('data-src');

		$(this).attr('src',src);

	});
	
});


// $(document).ready(function(){



// });