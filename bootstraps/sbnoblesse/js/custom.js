
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

function get_list_media(subDir)
{
	var url=$('#root_url').attr('content');

    var request = new XMLHttpRequest();
    request.open('POST', url+'api/media/load_file', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        $('.wrap_list_media > table > tbody').html(msg['data']);

      } else {
        // We reached our target server, but it returned an error
          

      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
       
    };

    request.send("send_path="+subDir);	
}


function remove_media(theEl,filename)
{
	var url=$('#root_url').attr('content');

    var request = new XMLHttpRequest();
    request.open('POST', url+'api/media/remove_file', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        theEl.parent().parent().remove();

      } else {
        // We reached our target server, but it returned an error
          

      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
       
    };

    request.send('send_filename='+filename);	
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




$( document ).on( "click", ".show_medial_modal", function() {

  $('#mediaModal').modal('show');

}); 



$( document ).on( "click", ".show_media_list", function() {

	get_list_media('');
  
}); 


$( document ).on( "click", ".media_dir", function() {

	var theDir=$(this).data('dir');

	get_list_media(theDir);
  
}); 



$( document ).on( "click", ".remove_media_file", function() {

	var el=$(this);

	var filename=el.attr('data-filename');

	if(confirm('Are you ensure remove this file ?'))
	{
		remove_media(el,filename);
	}
  
}); 

