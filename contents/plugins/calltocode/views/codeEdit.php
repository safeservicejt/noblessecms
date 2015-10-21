
<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>
<style type="text/css">
  
.content_type
{
  display: none;
}

.type_html
{
  display: block;
}

</style>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit code</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-8">
    	
        <?php echo $alert;?>
            <p>
                <label><strong>Title</strong></label>
                <input type="text" class="form-control" value="<?php echo $edit['title'];?>" name="send[title]" placeholder="Title" />
            </p>
 
            <p class="content_type type_html">
                <label><strong>Content</strong></label>
                <textarea id="editor" rows="15" name="send[content]" class="form-control ckeditor"><?php echo $edit['content'];?></textarea>
            </p>
            <p class="content_type type_other">
                <label><strong>Content</strong></label>
                <textarea rows="15" name="othercontent" class="form-control"><?php echo $edit['content'];?></textarea>
            </p>

            <p>
                <label><strong>Friendly Url</strong></label>
                <input type="text" class="form-control" value="<?php echo $edit['friendly_url'];?>" name="send[friendly_url]" placeholder="Friendly Url" />
            </p> 
            <p>
                <button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">
     
                <p>
                <label><strong>Code type:</strong></label>
                <select class="form-control select_type"  name="send[type]">
                <option value="html">Html</option>
                  <option value="css">Css</option>
                   <option value="js">Javascript</option>
                </select>
                </p>
                <p>
                <label><strong>Status:</strong></label>
                <select class="form-control" name="send[status]">
                <option value="1">Activate</option>
                  <option value="0">Deactivate</option>

                </select>
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
  CKEDITOR.replace( 'editor' );

  var type='<?php echo $edit["type"];?>';

  $(document).ready(function(){

    $('.select_type').change(function(){

      var value=$(this).val();

      if(value=='html')
      {
        $('.type_html').show();
        $('.type_other').hide();

      }
      else
      {
        $('.type_html').hide();
        $('.type_other').show();

      }

    });

    if(type=='html')
    {
        $('.type_html').show();
        $('.type_other').hide();
        $('.select_type').children('option').each(function(index, el) {
          if($(this).attr('value')=='html')
          {
            $(this).attr('selected',true);
          }

        });

    }
    else
    {

        $('.type_html').hide();
        $('.type_other').show();

        $('.select_type').children('option').each(function(index, el) {
          if($(this).attr('value')==type)
          {

            $(this).attr('selected',true);
          }
          
        });

    }


  });
</script>

