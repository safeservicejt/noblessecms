

$(document).ready(function(){

	var theWidth=$(window).height();
	$('.colLeft').css('min-height',theWidth+'px');


	$('.ulLeft > li').hover(function(){
		$(this).children('ul').slideDown('slow');

	},function(){
	$(this).children('ul').hide();

	});

	$('#selectAll').click(function(){
		
		 var c = this.checked;
	    $(':checkbox').prop('checked',c);
	});	

	
});