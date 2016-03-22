<script src="<?php echo System::getUrl(); ?>bootstrap/ckeditor/ckeditor.js"></script>

<?php echo System::getVar('page_addnew_header');?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new page</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-8">
    	
        <?php echo $alert;?>

        <div class="page_addnew_top_left"><?php echo System::getVar('page_addnew_top_left');?></div>
            <p>
                <label><strong>Title</strong></label>
                <input type="text" class="form-control page-title input-size-medium" name="send[title]" placeholder="Title" />
            </p>
 
            <p>
                <label><strong>Content</strong></label>
                <textarea id="editor" rows="15" name="send[content]" class="form-control page-content ckeditor"></textarea>
            </p>
            <p>
                <label><strong>Keywords</strong></label>
                <input type="text" class="form-control page-keywords input-size-medium" name="send[keywords]" placeholder="Keywords" />
            </p>
        <div class="page_addnew_bottom_left"><?php echo System::getVar('page_addnew_bottom_left');?> </div>         
            <p>
                <button type="submit" class="btn btn-primary" name="btnAdd">Add new</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">
     
        <div class="page_addnew_top_right"><?php echo System::getVar('page_addnew_top_right');?>  </div>       
                <p>
                <label><strong>Page type:</strong></label>
                <select class="form-control page-type" name="send[page_type]">
                <option value="normal">Normal</option>
                  <option value="image">Image</option>
                  <option value="fullwidth">Full Width</option>
                  <option value="page">Page</option>
                  <option value="forum">Forum</option>
                  <option value="box">Box</option>

                </select>
                </p>
                <p>
                <label><strong>Allow Comment:</strong></label>
                <select class="form-control page-allow-comment" name="send[allowcomment]">
                <option value="1">Yes</option>
                  <option value="0">No</option>

                </select>
                </p>
                <p>
                <label><strong>Publish:</strong></label>
                <select class="form-control page-status" name="send[status]">
                <option value="1">Yes</option>
                  <option value="0">No</option>

                </select>
                </p>

                <p>
                <label><strong>Upload Thumbnail</strong></label>
                <select class="form-control" name="uploadMethod" id="uploadMethod">
                <option value="frompc" data-target="uploadFromPC">From your pc</option>
                  <option value="fromurl" data-target="uploadFromUrl">From url</option>
                </select>

                </p>

             <p class="pupload uploadFromPC">
                <label><strong>Choose a image</strong></label>
                <input type="file" class="form-control" name="imageFromPC" />
            </p>     
             <p class="pupload uploadFromUrl" style="display:none;">
                <label><strong>Type image url</strong></label>
                <input type="text" class="form-control" name="imageFromUrl" placeholder="Type image url" />
            </p>     
        <div class="page_addnew_bottom_right"><?php echo System::getVar('page_addnew_bottom_right');?></div>                          
        </div>
        <!-- right -->
    </form>	
    </div>
  </div>
</div>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
CKEDITOR.replace( 'editor' ,{
  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   
</script>


  <script type="text/javascript">
            var root_url='<?php echo System::getUrl();?>';

$(document).ready(function(){
    $('#uploadMethod').change(function(){
        var option=$(this).children('option:selected');

        var target=option.attr('data-target');

        $('.pupload').hide();
        $('.'+target).slideDown('fast');

    });

});

  </script>

<?php echo System::getVar('page_addnew_footer');?>
