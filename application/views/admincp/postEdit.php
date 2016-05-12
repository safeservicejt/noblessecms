  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/chosen/bootstrap-chosen.css">
<script src="<?php echo System::getUrl(); ?>bootstrap/ckeditor/ckeditor.js"></script>

<?php echo System::getVar('post_edit_header');?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit post</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-8">
    	
        <?php echo $alert;?>

        <div class="post_edit_top_left"><?php echo System::getVar('post_edit_top_left');?></div>

            <p>
                <label><strong>Title</strong> (<span class="system_count_char" data-target=".post-title">0</span> characters)</label>
                <input type="text" class="form-control post-title" name="send[title]" value="<?php echo $edit['title'];?>" placeholder="Title" />
            </p>
            <p>
                <label><strong>Content</strong></label>
                <?php echo Render::renderBBCodeHtml();?>
                <textarea id="editor" rows="15" name="send[content]" class="form-control post-content ckeditor"><?php echo $edit['content'];?></textarea>
            </p>
            <p>
                <label><strong>Page Title</strong> (<span class="system_count_char" data-target=".post-page-title">0</span> characters)</label>
                <input type="text" class="form-control post-page-title" name="send[page_title]" value="<?php echo $edit['page_title'];?>" placeholder="Page Title" />
            </p>            
            <p>
                <label><strong>Descriptions</strong> (<span class="system_count_char" data-target=".post-descriptions">0</span> characters)</label>
                <input type="text" class="form-control post-descriptions" name="send[descriptions]" value="<?php echo $edit['descriptions'];?>" placeholder="Descriptions" />
            </p>
            <p>
                <label><strong>Keywords</strong> (<span class="system_count_char" data-target=".post-keywords">0</span> characters)</label>
                <input type="text" class="form-control post-keywords" name="send[keywords]" value="<?php echo $edit['keywords'];?>" placeholder="Keywords" />
            </p>
             
            <p>
                <label><strong>Tags (separate by commas)</strong></label>
                <input type="text" class="form-control post-tags" name="tags" value="<?php echo $tags;?>" placeholder="Tags" />
            </p>

        <div class="post_edit_bottom_left"><?php echo System::getVar('post_edit_bottom_left');?></div>

            <p>
                <button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">
        <div class="post_edit_top_right"><?php echo System::getVar('post_edit_top_right');?></div>
     
                <p class="pChosen">
                <div class="row">
                <div class="col-lg-12">
                <label><strong>Category</strong></label>
                <select name="send[catid]" class="form-control post-category chosen-select selected-parentid">
                    <?php if(isset($listCat[0]['catid'])){ ?>
                    <?php
                    $total=count($listCat);

                    $selected="";

                    $li='';

                    for ($i=0; $i < $total; $i++) { 

                        $selected="";

                        if((int)$listCat[$i]['catid']==(int)$edit['catid'])
                        {
                            $selected="selected";
                        }

                        $li.='<option value="'.$listCat[$i]['catid'].'" '.$selected.'>'.$listCat[$i]['title'].'</option>';
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
                <select class="form-control post-type" id="postType" name="send[type]">
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
                <select class="form-control post-allow-comment" id="allowComment" name="send[allowcomment]">
                <option value="1">Yes</option>
                  <option value="0">No</option>

                </select>
                </p>
                <p>
                <label><strong>Publish:</strong></label>
                <select class="form-control post-status" id="postStatus" name="send[status]">
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
                <p>
                <label><strong>Auto Crop Center</strong></label>
                <select class="form-control" name="autoCrop">
                  <option value="disable">Disable</option>
                  <option value="enable">Enable</option>
                </select>

                </p> 
            <p>
              <img src="<?php echo System::getUrl().$edit['image'];?>" class="img-responsive" />
            </p>

        <div class="post_edit_bottom_right"><?php echo System::getVar('post_edit_bottom_right');?></div>                              
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

            var postType='<?php echo $edit["type"];?>';

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

<?php echo Render::renderBBCodeJs();?>

<?php echo System::getVar('post_addnew_footer');?>