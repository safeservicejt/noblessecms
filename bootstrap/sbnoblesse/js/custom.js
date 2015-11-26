

$(document).ready(function() {
	
	$('.img-tools').click(function(){

		$('#modal-tools').modal('show');
	});

	$('.img-tools').animo( { animation: ['tada', 'bounce'], duration: 2 } );

	$('.img-tools').mouseover(function() {
		$(this).css({
			'opacity': '0.7'
		}).animo( { animation: ['tada', 'bounce'], duration: 2 } );
	});
	$('.img-tools').mouseout(function() {
		$(this).css({
			'opacity': '1'
		})
	});

});