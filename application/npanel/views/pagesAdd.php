<script src="<?php echo System::getUrl(); ?>bootstraps/ckeditor/ckeditor.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new page</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-8">
    	
        <?php echo $alert;?>

            <p>
                <label><strong>Title</strong> (<span class="system_count_char" data-target=".page-title">0</span> characters)</label>
                <input type="text" class="form-control page-title input-size-medium" name="send[title]" placeholder="Title" />
            </p>
 
            <p>
                <label><strong>Content</strong></label>
                <textarea id="editor" rows="15" name="send[content]" class="form-control page-content ckeditor"></textarea>
            </p>
            <p>
                <label><strong>Page Title</strong> (<span class="system_count_char" data-target=".page-page-title">0</span> characters)</label>
                <input type="text" class="form-control page-page-title input-size-medium" name="send[page_title]" placeholder="Page Title" />
            </p>
            <p>
                <label><strong>Descriptions</strong> (<span class="system_count_char" data-target=".page-descriptions">0</span> characters)</label>
                <input type="text" class="form-control page-descriptions input-size-medium" name="send[descriptions]" placeholder="Descriptions" />
            </p>
            <p>
                <label><strong>Keywords</strong> (<span class="system_count_char" data-target=".page-keywords">0</span> characters)</label>
                <input type="text" class="form-control page-keywords input-size-medium" name="send[keywords]" placeholder="Keywords" />
            </p>    
            <p>
                <button type="submit" class="btn btn-primary" name="btnAdd">Add new</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">
                <p>
                <label><strong>Page type:</strong></label>
                <select class="form-control page-type" name="send[type]">
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

$(document).ready(function(){
    $('#uploadMethod').change(function(){
        var option=$(this).children('option:selected');

        var target=option.attr('data-target');

        $('.pupload').hide();
        $('.'+target).slideDown('fast');

    });

});

  </script>

