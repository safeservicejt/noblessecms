

$(document).ready(function() {
	
	$('.img-tools').click(function(){

		$('#modal-tools').modal('show');
	});

	$('.img-tools').animo( { animation: ['tada', 'bounce'], duration: 2 } );

});