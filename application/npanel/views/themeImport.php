  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstraps/jsupload/css/jquery.fileupload.css">   

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Import templates</h3>


  </div>
	 <div class="panel-body">
	 <form action="" method="post" enctype="multipart/form-data" >
	     <?php echo $alert;?>
	    <strong>Choose file from your pc</strong><br>

        <!-- file upload -->
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success btn-sm fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Select files...</span>

            <!-- The file input field used as target for the file upload widget -->
            <input id="themeupload" type="file" name="files[]">
        </span>
        <span id="themefiles"></span>
        <br>
        <br>
        <!-- The global progress bar -->
        <div id="themeupload_progress" class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>                    
        <!-- file upload -->

        <div>
        	<br>
        	<span class="log-result"></span>
        </div>

	    <!-- <button type="submit" class="btn btn-primary" name="btnSend">Upload</button> -->
	 </form>
	</div>
</div>

<script src="<?php echo ROOT_URL;?>bootstraps/jsupload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo ROOT_URL;?>bootstraps/jsupload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo ROOT_URL;?>bootstraps/jsupload/js/jquery.fileupload.js"></script>  


<script type="text/javascript">



function send_file_to_unzip(str)
{
    var api_url='<?php echo System::getUrl();?>api/file/';
    
    var request = new XMLHttpRequest();
    request.open('POST', api_url+'import_theme', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);

        var msg = JSON.parse(request.responseText);

        if(msg['error']=='yes')
        {
        	// alert(msg['message']);

        	$('.log-result').html('Error: '+msg['message']);
        }
        else
        {
        	$('.log-result').html('Success unzip: '+str);
        }

      } else {
        // We reached our target server, but it returned an error
          // setTimeout(function(){ getStats(); },1000);
          alert(request.responseText);

      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
        // setTimeout(function(){ getStats(); },1000);
        alert(request.responseText);
    };

    request.send("send_filename="+str);

}

	$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '<?php echo ROOT_URL;?>api/media/upload_file';


    $('#themeupload').fileupload({
        url: url,
        dataType: 'json',
        limitMultiFileUploads : 20,
        done: function (e, data) {
          // console.log('Ảnh upload về');
          // console.log(data);
            $.each(data.result.files, function (index, file) {

                $('<p/>').text(file.name).appendTo('#themefiles');

                send_file_to_unzip(file.name);

                // clearlog();
                

            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#themeupload_progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});   
</script>