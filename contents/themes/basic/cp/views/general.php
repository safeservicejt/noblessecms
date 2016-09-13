<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>


<!-- right -->
  <div class="col-lg-9">
  
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Setting your theme</h3>
      </div>
      <div class="panel-body">


      <form action="" method="post" enctype="multipart/form-data">
      <?php if(Request::has('btnSend'))echo $alert;?>

        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-4">
            <strong>Enable facebook comment:</strong>
          </div>
          <div class="col-lg-8 text-right">
            <select class="form-control" name="send[facebook_comment_status]">
              <?php if(isset($facebook_comment_status)){ ?>
              <option value="<?php echo $facebook_comment_status;?>" selected><?php echo ucfirst($facebook_comment_status);?></option>
              <?php } ?>

              <option value="disable">Disable</option>
              <option value="enable">Enable</option>
              
            </select>
          </div>

        </div>
        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-4">
            <strong>Facebook App ID:</strong>
          </div>
          <div class="col-lg-8 text-right">
            <input type="text" class="form-control" name="send[facebook_app_id]" placeholder="Example: 187273434343443" value="<?php if(isset($facebook_app_id))echo $facebook_app_id;?>" />
          </div>

        </div>


        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-4">
            <strong>Upload your logo</strong>
          </div>
          <div class="col-lg-8 text-right">
            <input type="file" name="imgLogo" />
          </div>

        </div>

     
        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-12">
            <strong>Right Top Content:</strong>
          </div>
          <div class="col-lg-12">
            <textarea rows="5" name="send[site_right_top_content]" id="editor1" class="form-control"><?php if(isset($site_right_top_content))echo $site_right_top_content;?></textarea>
          </div>

        </div>       
        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-12">
            <strong>Right Bottom Content:</strong>
          </div>
          <div class="col-lg-12">
            <textarea rows="5" name="send[site_right_bottom_content]" id="editor2" class="form-control"><?php if(isset($site_right_bottom_content))echo $site_right_bottom_content;?></textarea>
          </div>

        </div>       

        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-12">
            <strong>Footer Content:</strong>
          </div>
          <div class="col-lg-12">
            <textarea rows="5" name="send[site_footer_content]" id="editor3" class="form-control"><?php if(isset($site_footer_content))echo $site_footer_content;?></textarea>
          </div>

        </div>

        <p>
          <button type="submit" name="btnSend" class="btn btn-primary btn-xs">Save changes</button>
        </p>
      </form>
      </div>
    </div> 


  </div>
<!-- right -->

</div>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
CKEDITOR.replace( 'editor1');
   
CKEDITOR.replace( 'editor2');   
   
CKEDITOR.replace( 'editor3');   
   

</script>
