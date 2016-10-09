<script src="<?php echo System::getUrl(); ?>bootstraps/ckeditor/ckeditor.js"></script>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit page</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-8">
    	
        <?php echo $alert;?>    
            <p>
                <label><strong>Title</strong> (<span class="system_count_char" data-target=".page-title">0</span> characters)</label>
                <input type="text" class="form-control page-title input-size-medium" name="send[title]" value="<?php echo $edit['title'];?>" placeholder="Title" />
            </p>
            <p>
                <label><strong>Content</strong></label>
                <textarea id="editor" rows="15" name="send[content]" class="form-control page-content ckeditor"><?php echo $edit['content'];?></textarea>
            </p>
            <p>
                <label><strong>Page Title</strong> (<span class="system_count_char" data-target=".page-page-title">0</span> characters)</label>
                <input type="text" class="form-control page-page-title input-size-medium" name="send[page_title]" value="<?php echo $edit['page_title'];?>" placeholder="Page Title" />
            </p>
            <p>
                <label><strong>Descriptions</strong> (<span class="system_count_char" data-target=".page-descriptions">0</span> characters)</label>
                <input type="text" class="form-control page-descriptions input-size-medium" value="<?php echo $edit['descriptions'];?>" name="send[descriptions]" placeholder="Descriptions" />
            </p>            
            <p>
                <label><strong>Keywords</strong></label>
                <input type="text" class="form-control page-keywords input-size-medium" name="send[keywords]" value="<?php echo $edit['keywords'];?>" placeholder="Keywords" />
            </p>             
            <p>
                <button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">
     
                <p>
                <label><strong>Page type:</strong></label>
                <select class="form-control page-type" id="postType" name="send[type]">
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
                <select class="form-control page-allow-comment" id="allowComment" name="send[allowcomment]">
                <option value="1">Yes</option>
                  <option value="0">No</option>

                </select>
                </p>
                <p>
                <label><strong>Publish:</strong></label>
                <select class="form-control page-status" id="postStatus" name="send[status]">
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
              <img src="<?php echo System::getUrl().$edit['image'];?>" class="img-responsive" />
            </p>                            
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
  extraPlugins: 'wordcount,notification,texttransform,justify',

  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstraps/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstraps/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   
</script>


  <script type="text/javascript">
            var root_url='<?php echo System::getUrl();?>';

            var postType='<?php echo $edit["page_type"];?>';

            var allowComment='<?php echo $edit["allowcomment"];?>';

            var postStatus='<?php echo $edit["status"];?>';



$(document).ready(function(){
    $('#uploadMethod').change(function(){
        var option=$(this).children('option:selected');

        var target=option.attr('data-target');

        $('.pupload').hide();
        $('.'+target).slideDown('fast');

    });


    $('select#postType option').each(function(){
      var thisVal=$(this).val();

      if(thisVal==postType)
      {
        $(this).attr('selected',true);
      }

    });
    $('select#postStatus option').each(function(){
      var thisVal=$(this).val();

      if(thisVal==postStatus)
      {
        $(this).attr('selected',true);
      }

    });
    $('select#allowComment option').each(function(){
      var thisVal=$(this).val();

      if(thisVal==allowComment)
      {
        $(this).attr('selected',true);
      }

    });

});
    
  </script>
