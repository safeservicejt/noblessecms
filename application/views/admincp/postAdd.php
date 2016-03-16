  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/chosen/bootstrap-chosen.css">
<script src="<?php echo System::getUrl(); ?>bootstrap/ckeditor/ckeditor.js"></script>

<?php echo System::getVar('post_addnew_header');?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new post</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-8">
    	
        <?php echo $alert;?>

        <?php echo System::getVar('post_addnew_top_left');?>

            <p>
                <label><strong>Title</strong></label>
                <input type="text" class="form-control input-size-medium" name="send[title]" placeholder="Title" />
            </p>
 
            <p>
                <label><strong>Content</strong></label>
                <textarea id="editor" rows="15" name="send[content]" class="form-control ckeditor"></textarea>
            </p>
            <p>
                <label><strong>Keywords</strong></label>
                <input type="text" class="form-control input-size-medium" name="send[keywords]" placeholder="Keywords" />
            </p> 
            <p>
                <label><strong>Tags (separate by commas)</strong></label>
                <input type="text" class="form-control input-size-medium" name="tags" placeholder="Tags" />
            </p>

        <?php echo System::getVar('post_addnew_bottom_left');?>

            <p>
                <button type="submit" class="btn btn-primary" name="btnAdd">Add new</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">

        <?php echo System::getVar('post_addnew_top_right');?>
     
                <p class="pChosen">
                <div class="row">
                <div class="col-lg-12">
                <label><strong>Category</strong></label>
                <select name="send[catid]" class="form-control chosen-select selected-parentid">
                    <?php if(isset($listCat[0]['catid'])){ ?>
                    <?php
                    $total=count($listCat);

                    $li='';

                    for ($i=0; $i < $total; $i++) { 

                        $li.='<option value="'.$listCat[$i]['catid'].'">'.$listCat[$i]['title'].'</option>';
                    }

                    echo $li;
                    ?>
                    <?php } ?>
                </select>
                </div>
                </div>

                </p> 
                <p>
                <label><strong>Post type:</strong></label>
                <select class="form-control" name="send[type]">
                <option value="normal">Normal</option>
                  <option value="image">Image</option>
                   <option value="video">Video</option>
                  <option value="fullwidth">Full Width</option>
                  <option value="news">News</option>
                  <option value="post">Post</option>
                  <option value="thread">Thread</option>
                  <option value="notify">Notify</option>

                </select>
                </p>
                <p>
                <label><strong>Allow Comment:</strong></label>
                <select class="form-control" name="send[allowcomment]">
                <option value="1">Yes</option>
                  <option value="0">No</option>

                </select>
                </p>
                <p>
                <label><strong>Publish:</strong></label>
                <select class="form-control" name="send[status]">
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
                <input type="text" class="form-control input-size-medium" name="imageFromUrl" placeholder="Type image url" />
            </p>     

            <p>
            <label><strong>Auto Crop Center</strong></label>
            <select class="form-control" name="autoCrop">
              <option value="disable">Disable</option>
              <option value="enable">Enable</option>
            </select>

            </p>      

        <?php echo System::getVar('post_addnew_bottom_right');?>                    
        </div>
        <!-- right -->
    </form>	
    </div>
  </div>
</div>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  // CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'editor' ,{
  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   

</script>
<script src="<?php echo ROOT_URL;?>bootstrap/chosen/chosen.jquery.js"></script>  
<script>
  $(function() {
    $('.chosen-select').chosen();
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

<?php echo System::getVar('post_addnew_footer');?>
