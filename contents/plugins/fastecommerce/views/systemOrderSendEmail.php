<script src="<?php echo System::getUrl(); ?>bootstrap/ckeditor/ckeditor.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Order #<?php echo $orderid;?> - Send Email</h3>
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
                          <input type="text" class="form-control input-size-medium" name="send[email]" value="<?php echo $userData['email'];?>" />
                      </p>
                     
                      <p>
                            <strong>Subject:</strong>
                          <input type="text" class="form-control input-size-medium" name="send[subject]" />
                      </p>

                      <p>
                            <strong>Payment Summary:</strong>
                          <textarea class="form-control editor" id="editor" name="send[content]" rows="10"></textarea>
                      </p>

                </div>

            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnSend" class="btn btn-primary">Send</button>
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

$(document).ready(function(){


});
</script>