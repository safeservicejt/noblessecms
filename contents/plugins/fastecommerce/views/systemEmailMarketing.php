<script src="<?php echo System::getUrl(); ?>bootstrap/ckeditor/ckeditor.js"></script>

<style type="text/css">
  
.wrap_custom_email
{
  display: none;
} 
</style>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Send Email</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
        <?php echo $alert;?>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                     
                      <p>
                            
                          <strong>To:</strong>
                          <select class="form-control select-email-group" name="send[to_group]">
                            <option value="newsletter">Newsletter Subscribers</option>
                            <option value="customers">Customers</option>
                            <option value="custom">Custom Email</option>
                          </select>
                      </p>

                      <p class="wrap_custom_email">
                      <strong>Custom Emails: (seperate by comma)</strong>
                      <input type="text" class="form-control input-size-medium custom_emails" name="send[custom_emails]" placeholder="email@gmail.com, email2@gmail.com" />
                      </p>
                     
                      <p>
                            <strong>Subject:</strong>
                          <input type="text" class="form-control input-size-medium subject" placeholder="Subject" name="send[subject]" />
                      </p>

                      <p>
                            <strong>Content:</strong>
                          <textarea class="form-control editor" id="editor" name="send[content]" rows="10"></textarea>
                      </p>

                </div>

            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="button" name="btnSend" class="btn btn-primary btnSend">Send</button>
                    <a href="<?php echo Http::get('refer');?>" class="btn btn-default pull-right">Back</a>
                </div>
            </div>
        </form>
        </div>
        
    </div>
  </div>
</div>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  // CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'editor' ,{
  extraPlugins: 'wordcount,notification,texttransform,justify',

  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   

</script>
<script>
var listEmail=[];

var totalEmail=0;

var curEmail=0;

var api_url='<?php echo System::getUrl();?>api/plugin/fastecommerce/';

var list_group='';

var status='none';

function send_email()
{
    if(status=='stop')
    {
      changeTitle('Stop success.');

      status='none';

      listEmail=[];

      totalEmail=0;

      curEmail=0;

      return false;
    }

    if(curEmail >= totalEmail)
    {
      changeTitle('Completed '+curEmail+'/'+totalEmail);

      status='none';

      listEmail=[];

      totalEmail=0;

      curEmail=0;

      return false;
    }


    var subject=$('.subject').val().trim();

    var editor=$('.cke_wysiwyg_frame').contents().find("body").html();

    var theEmail=listEmail[curEmail];

    if(theEmail.indexOf('@')==-1)
    {
      curEmail++;

      changeTitle('Completed '+curEmail+'/'+totalEmail);

      send_email();

      return false;
    }

    console.log('Sending email...');

    var request = new XMLHttpRequest();
    request.open('POST', api_url+'send_email', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        changeTitle(curEmail+'/'+totalEmail+' sending...');

        if(msg['error']=='yes')
        {
          changeTitle(msg['message']);
        }
        else
        {
          changeTitle('Completed...');
        }

        changeTitle(curEmail+'/'+totalEmail+' sending...');

        curEmail++;

        send_email();

      } else {
        // We reached our target server, but it returned an error
          alert(request.responseText);

          send_email();

      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
       alert('Error.');

       send_email();
    };

    request.send("send_subject="+subject+"&send_content="+editor+"&send_email="+theEmail);  
}

function get_list_email(callback)
{

    var request = new XMLHttpRequest();
    request.open('POST', api_url+'get_email_list_marketing', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        if(msg['error']=='yes')
        {
          changeTitle(msg['message']);

          alert(msg['message']);
        }
        else
        {
          listEmail=msg['data'];

          totalEmail=listEmail.length;

          curEmail=0;

          callback();
        }

      } else {
        // We reached our target server, but it returned an error
          alert(request.responseText);

      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
       alert('Error.');
    };

    request.send("send_list_group="+list_group);  
}

function changeTitle(str)
{
  $('title').text(str);
}

$(document).ready(function(){

  $('.select-email-group').change(function(){


    var theVal=$(this).val();

    if(theVal=='custom')
    {
      $('.wrap_custom_email').show();
    }
    else
    {
      $('.wrap_custom_email').hide();
    }

  });


  $('.btnSend').click(function(){


    if(status=='start')
    {
      if(confirm('Are you want stop last task ?'))
      {
        status='stop';
        
        listEmail=[];

        totalEmail=0;

        curEmail=0;

        return false;
      }

      return false;
    }

    if(confirm('Are you ensure will send email ?'))
    {
      list_group=$('.select-email-group').children('option:selected').val();

      status='start';

      if(list_group!='custom')
      {
        get_list_email(function(){
          send_email();
        });
      }
      else
      {
        var data=$('.custom_emails').val();

        listEmail=data.split(',');

        totalEmail=listEmail.length;

        curEmail=0;

        send_email();
      }

      

    }



  });

});
</script>