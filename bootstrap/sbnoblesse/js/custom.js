
function addContentToCkEditor(content)
{
	$('.ckeditor').val(content);	
}

function addContentToCustomCkEditor(id,position,content)
{
	$(id).val(content);	
}

function appendContentToCkEditor(content)
{
	var theVal=$('.ckeditor').val();
	$('.ckeditor').val(content+theVal);	
}

function appendContentToCustomCkEditor(id,position,content)
{
	var theVal=$(id).val();
	$(id).append(content+theVal);	
}

function prependContentToCkEditor(content)
{
	var theVal=$(id).val('.ckeditor');
	$('.ckeditor').prepend(theVal+content);	
}

function prependContentToCustomCkEditor(id,position,content)
{
	var theVal=$(id).val();
	$(id).prepend(theVal+content);	
}

function selectDrBox(id,theVal)
{
    $(id).children('option').each(function(index, el) {
        var theVal=$(this).attr('value');

        if(theVal==theVal)
        {
            $(this).attr('selected',true);
        }
    });
}


function system_listen_count_char(theEl,target)
{
	$(target).keyup(function(event) {
	  /* Act on the event */

	  var theLen=$(this).val().length;

	  theEl.text(theLen);

	});
}

function system_count_char(theEl,target)
{
  var theLen=$(target).val().length;

  theEl.text(theLen);
}

$(document).ready(function() {

	$('.img-tools').click(function(){

		$('#modal-tools').modal('show');
	});
	
	$('.show_modal_media').click(function(){
		$('#modal-media').modal('show');
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

	$('.system_count_char').each(function(index, el) {

	var theEl=$(this);

	var target=$(this).data('target');

	system_count_char(theEl,target);
	
	system_listen_count_char(theEl,target);

	});

});



