
$(window).scroll(function () {
    var height = $(window).scrollTop();

//    alert(height);

    if (height >= 190) {
        // do something
        $('.navbar-default').show();
    }
    else {
        $('.navbar-default').hide();
    }
});

$(document).ready(function(){

	$('#gotoTop').click(function(){

		$('html, body').animate({ scrollTop: 0 }, 'slow'); 
	});


$('.divProdThumbnail').hover(function(){

	var thisW=$(this).width();

	if(thisW <= 100)
	{
		$(this).children('.divWishList').css({

			top: "15%"

		});
	}

	$(this).children('.divFloatThumbnail').fadeIn('slow');

},function(){

	$(this).children('.divFloatThumbnail').fadeOut();	
});

});